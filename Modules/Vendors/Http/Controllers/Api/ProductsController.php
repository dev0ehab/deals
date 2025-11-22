<?php

namespace Modules\Vendors\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Products\Entities\Product;
use Modules\Products\Repositories\ProductRepository;
use Modules\Products\Transformers\ProductDetailsResource;
use Modules\Products\Transformers\ProductsResource;
use Modules\Support\Traits\ApiTrait;
use Modules\Vendors\Http\Requests\Api\StoreProductRequest;
use Modules\Vendors\Http\Requests\Api\UpdateProductRequest;

class ProductsController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * ProductsController constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the vendor's products.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $vendor = auth()->user();

        $products = Product::where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(request('perPage', 15));

        $data = ProductsResource::collection($products);

        return $this->sendResponse($data, 'success');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $vendor = auth()->user();

        // Add vendor_id to the request data
        $data = $request->validated();
        $data['vendor_id'] = $vendor->id;

        $product = $this->repository->create($data);

        $data = new ProductDetailsResource($product);

        return $this->sendResponse($data, trans('products::products.messages.created'));
    }

    /**
     * Display the specified product.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        $vendor = auth()->user();

        // Ensure the product belongs to the authenticated vendor
        if ($product->vendor_id !== $vendor->id) {
            return $this->sendError(trans('products::products.messages.not_found'));
        }

        $data = new ProductDetailsResource($product);

        return $this->sendResponse($data, 'success');
    }

    /**
     * Update the specified product in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $vendor = auth()->user();

        // Ensure the product belongs to the authenticated vendor
        if ($product->vendor_id !== $vendor->id) {
            return $this->sendError(trans('products::products.messages.not_found'));
        }

        $product = $this->repository->update($product, $request->validated());

        $data = new ProductDetailsResource($product);

        return $this->sendResponse($data, trans('products::products.messages.updated'));
    }

    /**
     * Remove the specified product from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $vendor = auth()->user();

        // Ensure the product belongs to the authenticated vendor
        if ($product->vendor_id !== $vendor->id) {
            return $this->sendError(trans('products::products.messages.not_found'));
        }

        $this->repository->delete($product);

        return $this->sendSuccess(trans('products::products.messages.deleted'));
    }
}

