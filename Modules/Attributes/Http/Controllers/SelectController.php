<?php

namespace Modules\Attributes\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Attributes\Entities\Category;
use Modules\Attributes\Entities\BulkDiscount;
use Modules\Attributes\Entities\PricingMatrix;
use Modules\Attributes\Transformers\CategoryResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;


    public function index()
    {
        $categories = Category::active()->whereHas('attributes', function ($query) {
            $query->inPriceMatrix();
        })->with('attributes', function ($query) {
            $query->inPriceMatrix()->active()->with('options', function ($query) {
                $query->inPriceMatrix();
            })->orderBy('rank');
        })->orderBy('rank')->get();

        return $this->sendResponse(CategoryResource::collection($categories), 'Categories fetched successfully');
    }


    public function getPricingMatrix()
    {
        $pricingMatrix = PricingMatrix::get(["key", "value"]);
        return $this->sendResponse($pricingMatrix, 'Pricing matrix fetched successfully');
    }


    public function getBulkDiscountPercent()
    {
        $bulkDiscountPercent = BulkDiscount::orderBy('from', 'asc')->get(["from", "to", "percent"]);
        return $this->sendResponse($bulkDiscountPercent, 'Bulk discount percent fetched successfully');
    }

}
