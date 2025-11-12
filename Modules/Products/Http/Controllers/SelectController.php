<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Products\Entities\Product;
use Modules\Products\Repositories\ProductRepository;
use Modules\Products\Transformers\ProductDetailsResource;
use Modules\Products\Transformers\ProductsResource;
use Modules\Products\Transformers\ProductRatesResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;

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
        $this->repository = $repository;
    }



    public function index()
    {
        $products = $this->repository->allApi();
        return $this->sendResponse(ProductsResource::collection($products)->response()->getData(true), __('Data Found'));
    }

    public function show($id)
    {
        $service = Product::findOrFail($id)->load('features.featureOptions' , 'section');
        $data = new ProductDetailsResource($service);
        return $this->sendResponse($data, __('Data Found'));
    }


    public function rates($id)
    {
        $product = Product::findOrFail($id);
        $rates = $product->orderProducts()->inRandomOrder()->with('order.user')->where('rate', '!=', null)->where('is_rate_accepted', 1)->paginate(10);
        return $this->sendResponse(ProductRatesResource::collection($rates)->response()->getData(true), __('Data Found'));
    }
}
