<?php

namespace Modules\Orders\Repositories;

use App\Enums\DeliveryTypeEnum;
use App\Services\PageCountExtractorService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Addresses\Entities\Address;
use Modules\Attributes\Entities\AttributeOption;
use Modules\Attributes\Entities\BulkDiscount;
use Modules\Attributes\Entities\PricingMatrix;
use Modules\Contracts\CrudRepository;
use Modules\Coupons\Repositories\CouponRepository;
use Modules\Dashboard\Transformers\MediaResource;
use Modules\Orders\Entities\Order;
use Modules\Orders\Entities\OrderFile;
use Modules\Orders\Entities\OrderProduct;
use Modules\Orders\Entities\OrderProductFeature;
use Modules\Orders\Entities\StandaloneMedia;
use Modules\Orders\Http\Filters\OrderFilter;
use Modules\Coupons\Http\Filters\CouponFilter;
use Modules\Products\Entities\Product;
use Modules\Support\Traits\ApiTrait;

class OrderRepository implements CrudRepository
{
    use ApiTrait;
    private $filter;
    private $pageCountExtractor;

    private $options;
    /**
     * OrderRepository constructor.
     * @param OrderFilter $filter
     * @param PageCountExtractorService $pageCountExtractor
     */
    public function __construct(OrderFilter $filter, PageCountExtractorService $pageCountExtractor)
    {
        $this->filter = $filter;
        $this->pageCountExtractor = $pageCountExtractor;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function all()
    {
        request()->merge(['status' => request()->status ?? 'pending']);

        return Order::filter($this->filter)->latest()->paginate(request('perPage'));
    }

    /**
     * @return LengthAwarePaginator
     */
    public function allApi()
    {
        return auth()->user()->orders()->filter($this->filter)->latest()->paginate(request('perPage'));
    }


    /**
     * @param array $data
     * @return Order $order
     */
    public function create(array $data): Order
    {
        if ($data['delivery_type'] == DeliveryTypeEnum::DELIVERY->value && isset($data['address_id'])) {
            $address = Address::find($data['address_id']);
            $delivery_price = $address->delivery_price;
        } else {
            $delivery_price = 0;
        }


        $this->setOptions();
        $order_data = [];
        $order_data['sub_total'] = 0;
        $bulk_discount = 0;
        $coupon_discount = 0;
        $final_paper_count = 0;
        $order = auth()->user()->orders()->create($data);

        if (isset($data['print'])) {
            foreach ($data['print'] as $print) {

                [$paper_count, $paper_price, $sub_total, $addons, $total, $real_paper_count] = $this->getPaperPrice($print);

                $print_model = $order->orderFiles()->create($print + [
                    'paper_price' => $paper_price,
                    'sub_total' => $sub_total,
                    'addons' => $addons,
                    'total' => $total,
                    'real_paper_count' => $real_paper_count,
                ]);

                $order_data['sub_total'] += $total;
                $final_paper_count += $paper_count;

                \DB::table('media')->where('id', $print['media_id'])->update([
                    'model_id' => $print_model->id,
                    'model_type' => OrderFile::class,
                ]);

                $print_model->fileAttributes()->createMany($print['attributes']);
            }

            $order_data['sub_total'] = round($order_data['sub_total'], 2);



            $bulk_discount = $this->getBulkDiscount($final_paper_count);
        }

        if (isset($data['products'])) {
            $product_ids = array_column($data['products'], 'id');
            $products = Product::find($product_ids);
            foreach ($data['products'] as $product) {
                $product_model = $products->where('id', $product['id'])->first();

                if ($product_model->stock < $product['quantity']) {
                    throw new Exception(__("orders::validation.product_stock_not_enough", ['name' => $product_model->name]));
                }

                $product_model->stock -= $product['quantity'];
                $product_model->save();


                $order_product = $order->orderProducts()->create([
                    'product_id' => $product_model->id,
                    'quantity' => $product['quantity'],
                    'price' => $product_model->price,
                    'total' => $product_model->price * $product['quantity'],
                ]);

                if (isset($product['features'])) {
                    foreach ($product['features'] as $feature) {
                        $order_product_feature = $order_product->orderProductFeatures()->create($feature);

                        if (isset($feature['image'])) {
                            $order_product_feature->addMedia($feature['image'])->toMediaCollection('images');
                        }
                    }
                }

                $order_data["sub_total"] += $product_model->price * $product['quantity'];
            }
        }

        if (isset($data['coupon_code'])) {
            $couponReposatry = new CouponRepository(new CouponFilter());
            [$coupon_discount, $order_data["coupon_id"], $coupon_type] = $couponReposatry->applyCoupon($data['coupon_code'], $order_data['sub_total']);
        }

        $order_data['bulk_discount'] = round($bulk_discount * $order_data['sub_total'] / 100, 2);
        $order_data['tax'] = round($order_data['sub_total'] * 0, 2);
        $order_data['delivery_fee'] = round($delivery_price, 2);
        $order_data['discount'] = isset($coupon_type) && $coupon_type == 'delivery' ? $order_data['delivery_fee'] : round($coupon_discount, 2);
        $order_data['total'] = round($order_data['sub_total'] + $order_data['tax'] + $order_data['delivery_fee'] - $order_data['bulk_discount'] - $order_data['discount'], 2);

        $order->update($order_data);


        return $order->refresh();
    }

    /**
     * @param mixed $model
     * @return Model|void
     */
    public function find($model)
    {
        if ($model instanceof Order) {
            return $model;
        }

        return Order::findOrFail($model);
    }

    /**
     * @param mixed $model
     * @param array $data
     * @return void
     */
    public function update($model, array $data)
    {
        $model->update($data);

        return $model->refresh();
    }

    /**
     * @param mixed $model
     */
    public function delete($model)
    {
        $this->find($model)->delete();
    }

    /**
     * Change the given order status.
     *
     * @param mixed $model
     * @return Order $order
     * @throws \Exception
     */
    public function changeStatus($model)
    {
        $order = $this->find($model);
        $order->update(['status' => request('status')]);
        return $order;
    }


    public function uploadMedia(array $data)
    {
        $media = StandaloneMedia::create($data);
        $files = [];

        foreach ($data['files'] as $file) {
            $media_file = $media->addMedia($file)->toMediaCollection('files');

            // Extract page count for supported file types
            $pageCount = $this->pageCountExtractor->getPageCount(
                $media_file->getPath(),
                $media_file->mime_type
            );

            // Debug presentation files specifically
            if (
                in_array($media_file->mime_type, [
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                ])
            ) {
                $debug = $this->pageCountExtractor->debugPageCountExtraction(
                    $media_file->getPath(),
                    $media_file->mime_type
                );
                \Log::info('Presentation Debug Info:', $debug);
            }

            // Store page count in the paper_count column and as custom property
            $media_file->paper_count = $pageCount;
            $media_file->setCustomProperty('page_count', $pageCount);
            $media_file->setCustomProperty('file_type', $this->pageCountExtractor->getFileType($media_file->mime_type));
            $media_file->save();

            $files[] = (object) $media_file;
            $media_file->model_id = null;
            $media_file->model_type = null;
            $media_file->save();
        }
        $media->delete();

        return MediaResource::collection(collect($files));
    }



    public function getPaperPrice($print)
    {
        $copy_count = \DB::table('media')->find($print['media_id'])?->paper_count;
        $option_ids = array_column($print['attributes'], column_key: 'attribute_option_id');
        $paper_price_options = $this->getOptions($option_ids)->where('attribute_price_type', 'paper_price');
        $paper_count_factor = collect($this->getOptions($option_ids)->pluck('paper_count_factor'))->reduce(fn($carry, $item) => $carry * $item, 1);
        $paper_matrix = implode('-', $paper_price_options->pluck('id')->toArray());

        if (count(explode('-', $paper_matrix)) != count(explode('-', PricingMatrix::first()->key))) {
            throw new Exception(__("Paper matrix not found"));
        }

        $paper_price = PricingMatrix::where('key', $paper_matrix)->first()->value;
        $real_copy_count = ceil($copy_count / $paper_count_factor);
        $paper_count = $real_copy_count * $print['copies'];
        $sub_total = round($paper_price * $paper_count, 2);
        $addons = $this->getOptions($option_ids)->where('attribute_price_type', 'total_price')->sum('price');
        $total = round($sub_total + $addons, 2);

        return [
            $paper_count,
            $paper_price,
            $sub_total,
            $addons,
            $total,
            $real_copy_count,
        ];
    }


    public function getOptions($option_ids)
    {
        return $this->options->whereIn('id', $option_ids);
    }

    public function setOptions()
    {
        return $this->options = AttributeOption::with('attribute:id,pricing_type')->get(["id", "attribute_id", "price", "paper_count_factor"])->each(function ($option) {
            $option->attribute_price_type = $option->attribute->pricing_type;
            return $option;
        });
    }


    public function getBulkDiscount($final_paper_count)
    {
        $percent = BulkDiscount::where('from', '<=', $final_paper_count)->where('to', '>=', $final_paper_count)->first()?->percent;

        if (!$percent) {
            $discount = BulkDiscount::orderBy('from', 'desc')->first();
            $percent = $discount->from < $final_paper_count ? $discount->percent : 0;
        }

        return $percent;
    }



    public function rate(Order $order, array $data)
    {
        if (isset($data['print_rate'])) {

            if ($order->print_rate) {
                throw new Exception(__("orders::validation.order_already_rated_print"));
            }

            $order->print_rate = $data['print_rate'];
            $order->save();
        }

        
        if (isset($data['order_products'])) {
            foreach ($data['order_products'] as $order_product) {
                $order_product_model = OrderProduct::with('product')->firstWhere('id', $order_product['id']);

                if ($order_product_model->rate) {
                    throw new Exception(__("orders::validation.order_product_already_rated", ['name' => $order_product_model->product->name]));
                }
                $order_product_model->update($order_product);

                $average_rate = OrderProduct::where('product_id', $order_product_model->product_id)->avg('rate');
                $order_product_model->product->update(['rate' => $average_rate]);
            }
        }


        return $order->refresh();
    }
}
