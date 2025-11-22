<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Products\Entities\Product;
use Modules\Products\Http\Requests\ProductRequest;
use Modules\Products\Repositories\ProductRepository;
use Modules\Washers\Entities\Washer;

class ProductsController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * CountryController constructor.
     *
     * @param ProductRepository $repository
     *
     */
    public function __construct(ProductRepository $repository)
    {
        $this->middleware('permission:read_products')->only(['index']);
        $this->middleware('permission:create_products')->only(['create', 'store']);
        $this->middleware('permission:update_products')->only(['edit', 'update']);
        $this->middleware('permission:delete_products')->only(['destroy']);
        $this->middleware('permission:show_products')->only(['show']);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $products = $this->repository->all();

        return view('products::products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('products::products.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     */
    public function store(ProductRequest $request)
    {
        $product = $this->repository->create($request->all());

        flash(trans('products::products.messages.created'))->success();

        return redirect()->route('dashboard.products.show', $product);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product)
    {
        $product = $this->repository->find($product);

        return view('products::products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     *
     */
    public function edit(Product $product)
    {
        return view('products::products.edit' , get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product = $this->repository->update($product, $request->all());

        flash(trans('products::products.messages.updated'))->success();

        return redirect()->route('dashboard.products.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     */
    public function destroy(Product $product)
    {
        $exists = $this->canDelete($product);

        if (!$exists) {
            $this->repository->delete($product);
        }

        flash(trans('products::products.messages.' . ($exists ? "cant-delete" : "deleted")))->error();

        return redirect()->route('dashboard.products.index');
    }

    public function canDelete($product)
    {
        return false ;
    }

    public function activate(Request $request, Product $product)
    {
        activate($product, $request->status);
        $msg = $product->isActive() ? __("products::products.messages.activated") : __("products::products.messages.deactivated");
        return response()->json([
            'active' => $product->isActive(),
            'msg' => $msg,
        ], 200);
    }

}
