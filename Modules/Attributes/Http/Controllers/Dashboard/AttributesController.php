<?php

namespace Modules\Attributes\Http\Controllers\Dashboard;

use App\Enums\AttributePricingEnum;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\Attributes\Entities\Attribute;
use Modules\Attributes\Entities\BulkDiscount;
use Modules\Attributes\Entities\PricingMatrix;
use Modules\Attributes\Http\Requests\AttributeRequest;
use Modules\Attributes\Repositories\AttributeRepository;

class AttributesController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var AttributeRepository
     */
    private $repository;

    /**
     * CountryController constructor.
     *
     * @param AttributeRepository $repository
     */
    public function __construct(AttributeRepository $repository)
    {
        $this->middleware('permission:read_attributes')->only(['index']);
        $this->middleware('permission:create_attributes')->only(['create', 'store']);
        $this->middleware('permission:update_attributes')->only(['edit', 'update']);
        $this->middleware('permission:delete_attributes')->only(['destroy']);
        $this->middleware('permission:show_attributes')->only(['show']);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $attributes = $this->repository->all();
        return view('attributes::attributes.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('attributes::attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(AttributeRequest $request)
    {
        $attribute = $this->repository->create($request->all());

        flash(trans('attributes::attributes.messages.created'))->success();

        return redirect()->route('dashboard.attributes.show', $attribute);
    }

    /**
     * Display the specified resource.
     *
     * @param Attribute $attribute
     *
     */
    public function show(Attribute $attribute)
    {
        $attribute = $this->repository->find($attribute);

        return view('attributes::attributes.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Attribute $attribute
     */
    public function edit(Attribute $attribute)
    {
        return view('attributes::attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Attribute $attribute
     */
    public function update(AttributeRequest $request, Attribute $attribute)
    {
        $attribute = $this->repository->update($attribute, $request->all());

        flash(trans('attributes::attributes.messages.updated'))->success();

        return redirect()->route('dashboard.attributes.show', $attribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Attribute $attribute)
    {
        $this->repository->delete($attribute);

        flash(trans('attributes::attributes.messages.deleted'))->error();

        return redirect()->back();
    }

    /**
     * Activate the specified resource.
     * @param Attribute $attribute
     */
    public function activate(Request $request, Attribute $attribute)
    {
        activate($attribute, $request->status);
        $msg = $attribute->isActive() ? __("attributes::attributes.messages.activated") : __("attributes::attributes.messages.deactivated");
        return response()->json([
            'active' => $attribute->is_active,
            'msg' => $msg,
        ], 200);
    }

    public function getOrder()
    {
        $attributes = $this->repository->order();
        return view('attributes::attributes.order', get_defined_vars());
    }


    public function order(Request $request)
    {
        foreach (request('attributes') as $key => $attribute) {
            $rank = $key + 1;
            Attribute::where('id', $attribute)->update([
                'rank' => $rank,
            ]);
        }

        flash(trans('attributes::attributes.messages.ordered'))->success();

        return redirect()->route('dashboard.order.form.attributes');
    }



    public function getPricingMatrix()
    {
        $matrix_data = [];
        $attributes = Attribute::active()->where('pricing_type', AttributePricingEnum::PAPER_PRICE->value)->with('options')->get();
        $options = $attributes->pluck('options')->flatten();

        $matrix = generateAttributeMatrix($attributes);

        $matrix_model = PricingMatrix::whereIn('key', $matrix)->get();

        foreach ($matrix as $key => $value) {
            $data            = [];
            $data['name']    = $value;
            $data['value']   = $matrix_model->where('key', $value)->first()->value ?? 0;
            $data['options'] = $options->whereIn('id', explode('-', $value))->pluck("name")->toArray();
            $matrix_data[]   = $data;
        }

        return view('attributes::attributes.pricing_matrix', get_defined_vars());
    }



    public function getBulkDiscountPercent()
    {
        $bulkDiscountPercent = BulkDiscount::orderBy('from', 'asc')->get(["from", "to", "percent"]);
        return view('attributes::attributes.bulk_discount_percent', get_defined_vars());
    }

    public function updatePricingMatrix(Request $request)
    {
        PricingMatrix::truncate();
        foreach ($request->pricing_matrix as $key => $value) {
            $data[] = [
                'key' => $key,
                'value' => $value,
            ];
        }
        PricingMatrix::insert($data);

        flash(trans('attributes::attributes.messages.pricing_matrix_updated'))->success();
        return redirect()->route('dashboard.attributes.pricing.matrix');
    }

    public function updateBulkDiscountPercent(Request $request)
    {
        $request->validate([
            'bulk_discounts'           => 'required|array',
            'bulk_discounts.*.from'    => 'required|integer|min:1',
            'bulk_discounts.*.to'      => 'required|integer|min:1',
            'bulk_discounts.*.percent' => 'required|numeric|min:0|max:100',
        ]);

        // Additional validation for range logic
        $ranges = $request->bulk_discounts;
        foreach ($ranges as $index => $range) {
            if ($range['from'] > $range['to']) {
                return redirect()->back()->withErrors([
                    "bulk_discounts.{$index}.from" => 'From value cannot be greater than To value'
                ]);
            }
        }

        // Check for overlapping ranges
        usort($ranges, function($a, $b) {
            return $a['from'] - $b['from'];
        });

        for ($i = 0; $i < count($ranges) - 1; $i++) {
            if ($ranges[$i]['to'] >= $ranges[$i + 1]['from']) {
                return redirect()->back()->withErrors([
                    'bulk_discounts' => 'Overlapping ranges are not allowed'
                ]);
            }
        }

        // Clear existing bulk discounts
        BulkDiscount::truncate();

        // Create new bulk discounts
        foreach ($request->bulk_discounts as $discount) {
            BulkDiscount::create([
                'from' => $discount['from'],
                'to' => $discount['to'],
                'percent' => $discount['percent'],
            ]);
        }

        flash(trans('attributes::attributes.messages.bulk_discount_updated'))->success();
        return redirect()->route('dashboard.attributes.bulk.discount');
    }
}
