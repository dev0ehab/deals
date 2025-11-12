<?php

namespace Modules\Attributes\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\Attributes\Entities\Category;
use Modules\Attributes\Http\Requests\CategoryRequest;
use Modules\Attributes\Repositories\CategoryRepository;

class CategoriesController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var CategoryRepository
     */
    private $repository;

    /**
        * CategoriesController constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->middleware('permission:read_categories')->only(['index']);
        $this->middleware('permission:create_categories')->only(['create', 'store']);
        $this->middleware('permission:update_categories')->only(['edit', 'update']);
        $this->middleware('permission:delete_categories')->only(['destroy']);
        $this->middleware('permission:show_categories')->only(['show']);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $categories = $this->repository->all();
        return view('attributes::categories.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('attributes::categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->repository->create($request->all());

        flash(trans('attributes::categories.messages.created'))->success();

        return redirect()->route('dashboard.categories.show', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     *
     */
    public function show(Category $category)
    {
        $category = $this->repository->find($category);

        return view('attributes::categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
        * @param Category $category
     */
    public function edit(Category $category)
    {
        return view('attributes::categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category = $this->repository->update($category, $request->all());

        flash(trans('attributes::categories.messages.updated'))->success();

        return redirect()->route('dashboard.categories.show', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     */
    public function destroy(Category $category)
    {

        if ($category->attributes->count() > 0) {
            flash(trans('attributes::categories.messages.cant_delete_category_has_attributes'))->error();
            return redirect()->route('dashboard.categories.index', $category);
        }

        $this->repository->delete($category);

        flash(trans('attributes::categories.messages.deleted'))->success();

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Activate the specified resource.
     *
     * @param Category $category
     */
    public function activate(Request $request, Category $category)
    {
        activate($category, $request->status);
        $msg = $category->isActive() ? __("attributes::categories.messages.activated") : __("attributes::categories.messages.deactivated");
        return response()->json([
            'active' => $category->is_active,
            'msg' => $msg,
        ], 200);
    }


    public function getOrder()
    {
        $categories = $this->repository->order();
        return view('attributes::categories.order', get_defined_vars());
    }


    public function order(Request $request)
    {
        foreach ($request->categories as $key => $category) {
            $rank = $key + 1;
            Category::where('id', $category)->update([
                'rank' => $rank,
            ]);
        }

        flash(trans('attributes::categories.messages.ordered'))->success();

        return redirect()->route('dashboard.order.form.categories');
    }
}
