<?php

namespace Modules\Roles\Http\Controllers\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Accounts\Entities\Admin;
use Modules\Accounts\Entities\User;
use Modules\Roles\Entities\Role;
use Modules\Roles\Http\Requests\RoleRequest;
use Modules\Roles\Repositories\RoleRepository;

class RoleController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var RoleRepository
     */
    private $repository;

    /**
     * RoleController constructor.
     * @param RoleRepository $repository
     */
    public function __construct(RoleRepository $repository)
    {
        $this->middleware('permission:read_roles')->only(['index']);
        $this->middleware('permission:create_roles')->only(['create', 'store']);
        $this->middleware('permission:update_roles')->only(['edit', 'update']);
        $this->middleware('permission:delete_roles')->only(['destroy']);
        $this->middleware('permission:show_roles')->only(['show']);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $roles = $this->repository->all();

        return view('roles::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View
     */
    public function create()
    {
        return view('roles::roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        $role = $this->repository->create($request->all());

        flash(trans('roles::roles.messages.created'))->success();

        return redirect()->route('dashboard.roles.show', $role);
    }

    /**
     * Show the specified resource.
     * @param Role $role
     * @return Factory|View
     */
    public function show(Role $role)
    {
        $role = $this->repository->find($role);

        return view('roles::roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Role $role
     * @return Factory|View
     */
    public function edit(Role $role)
    {
        return view('roles::roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     * @param RoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role = $this->repository->update($role, $request->all());

        flash(trans('roles::roles.messages.updated'))->success();

        return redirect()->route('dashboard.roles.show', $role);
    }

    /**
     * Remove the specified resource from storage.
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role)
    {

        $exists = $this->canDelete($role->id);

        if (!$exists) {
            $this->repository->delete($role);
        }

        flash(trans('roles::roles.messages.' . ($exists ? "cant-delete" : "deleted")))->error();

        return redirect()->route('dashboard.roles.index');
    }



    public function canDelete($roleId)
    {
        return Admin::whereHas("roles" , fn($q) => $q->whereId($roleId))->count() ;
    }

}
