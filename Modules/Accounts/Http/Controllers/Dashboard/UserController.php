<?php

namespace Modules\Accounts\Http\Controllers\Dashboard;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Http\Requests\UserRequest;
use Modules\Accounts\Repositories\UserRepository;

class UserController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * The repository instance.
     *
     * @var UserRepository
     */
    private $repository;

    /**
     * AdminController constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('permission:read_users')->only(['index']);
        $this->middleware('permission:create_users')->only(['create', 'store']);
        $this->middleware('permission:update_users')->only(['edit', 'update']);
        $this->middleware('permission:delete_users')->only(['destroy']);
        $this->middleware('permission:show_users')->only(['show']);
        $this->middleware('permission:readTrashed_users')->only(['trashed']);
        $this->middleware('permission:restore_users')->only(['restore']);
        $this->middleware('permission:forceDelete_users')->only(['forceDelete']);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = $this->repository->all();
        return view('accounts::users.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('accounts::users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(UserRequest $request)
    {
        $user = $this->repository->create($request->allWithHashedPassword());

        flash(trans('accounts::user.messages.created'))->success();

        return redirect()->route('dashboard.users.show', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function show(User $user)
    {
        $user = $this->repository->find($user);

        return view('accounts::users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        $user = $this->repository->find($user);

        return view('accounts::users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(UserRequest $request, User $user)
    {
        $user = $this->repository->update($user, $request->allWithHashedPassword());
        if ($request->has('password')) {
            $user->sendSmsNewPasswordNotification($request->password);
        }
        flash(trans('accounts::user.messages.updated'))->success();

        return redirect()->route('dashboard.users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        if (auth()->user()->is($user)) {
            abort(403, 'cannot be deleted due to that your account.');
        }

        $this->repository->delete($user);

        flash(trans('accounts::user.messages.deleted'))->error();

        return redirect()->route('dashboard.users.index');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function block(User $user)
    {
        $this->repository->block($user);

        flash(trans('accounts::user.messages.blocked'))->success();

        return redirect()->route('dashboard.users.index');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function unblock(User $user)
    {
        $this->repository->unblock($user);

        flash(trans('accounts::user.messages.unblocked'))->success();

        return redirect()->route('dashboard.users.index');
    }

    /**
     *  Display a listing of the trashed resource.
     * @param User $user
     * @return View
     */
    public function trashed()
    {
        $users = $this->repository->trashed();
        return view('accounts::users.trashed', compact('users'));
    }

    /**
     * force delete the specified resource from storage.
     * @param User $user
     * @return View
     */
    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);

        $this->repository->forceDelete($user);

        flash(trans('accounts::user.messages.forceDeleted'))->error();

        return redirect()->route('dashboard.users.trashed');
    }

    /**
     * Restore the specified resource from storage.
     * @param User $user
     * @return View
     */
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);

        $this->repository->restore($user);

        flash(trans('accounts::user.messages.restored'))->success();

        return redirect()->route('dashboard.users.trashed');
    }
}
