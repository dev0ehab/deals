<?php

namespace Modules\Accounts\Http\Controllers\Api;

use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Http\Filters\RateFilter;
use Modules\Accounts\Http\Requests\Api\RateApiRequest;
use Modules\Accounts\Repositories\RateRepository;
use Modules\Products\Entities\Product;
use Modules\Support\Traits\ApiTrait;
use Modules\Support\Traits\Rateable;
use Modules\Vendors\Entities\Rate;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Transformers\RatesResource;
use Request;

class RateController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;


    protected $rateRepository;

    public function __construct(RateRepository $rateRepository)
    {
        $this->middleware('isUser');
        $this->rateRepository = $rateRepository;
    }

    public function index(RateFilter $filter)
    {
        $rates = Rate::filter($filter)->paginate(request('perPage'));
        return $this->sendResponse(RatesResource::collection($rates)->response()->getData(true), __("accounts::rate.messages.created"));
    }

    public function store(RateApiRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $rateableType = !empty($validated['product_id']) ? 'product' : 'vendor';

        $rateableClass = !empty($validated['product_id']) ?  Product::class : Vendor::class;

        $rateableId = $validated[$rateableType . '_id'];

        $rateable =  $rateableClass::findOrFail($rateableId);

        $rate = $this->rateRepository->create($user, $validated, $rateable->id, get_class($rateable));

        if ($rateableType == 'product') {
            $this->rateRepository->updateRateableRating($rateable->id, get_class($rateable));
            $rateable = $rateable->vendor;
            $rate = $this->rateRepository->create($user, $validated, $rateable->id, get_class($rateable));
            $this->rateRepository->updateRateableRating($rateable->id, get_class($rateable));
        } else {
            $this->rateRepository->updateRateableRating($rateable->id, get_class($rateable));
        }

        $data = new RatesResource($rate);
        return $this->sendResponse($data, __("accounts::rate.messages.created"));
    }
}
