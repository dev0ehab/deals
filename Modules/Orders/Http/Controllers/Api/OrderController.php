<?php

namespace Modules\Orders\Http\Controllers\Api;

use App\Services\PaymentGateways\MyfatoorahService;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Orders\Entities\Order;
use Modules\Orders\Events\UpdateOrderStatusEvent;
use Modules\Orders\Http\Requests\CancelOrderRequest;
use Modules\Orders\Http\Requests\OrderRateRequest;
use Modules\Orders\Http\Requests\OrderRequest;
use Modules\Orders\Http\Requests\UploadMediaRequest;
use Modules\Orders\Repositories\OrderRepository;
use Modules\Orders\Transformers\OrderResource;
use Modules\Support\Traits\ApiTrait;
use Throwable;

class OrderController extends Controller
{
    use ApiTrait;

    /**
     * @var OrderRepository
     */
    private OrderRepository $repository;

    /**
     * OrderController constructor.
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $orders = $this->repository->allApi();

        $data = OrderResource::collection($orders)->response()->getData(true);

        return $this->sendResponse($data, 'Success');
    }


    /**
     * @param OrderRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(OrderRequest $request, MyfatoorahService $myfatoorahService)
    {
        $data = $request->all();

        try {
            DB::beginTransaction();

            $order = $this->repository->create($data);

            // $payment = $myfatoorahService->sendPayment($order->user->name, $order->user->phone, $order->user->email, $order->total, "SAR", $order);

            // $order->invoice_id  = $payment->Data->InvoiceId;

            // $order->save();

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            return $this->sendErrorData(["error" => [$message]], $message);
        }

        $data = OrderResource::make($order);

        // $data = $data->setPaymentUrl($payment->Data->InvoiceURL);

        return $this->sendResponse($data, 'success');
    }


    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        $data = new OrderResource($order);

        return $this->sendResponse($data, 'success');
    }


    public function update(OrderRequest $request, Order $order)
    {
        $data = $request->validated();

        $order = $this->repository->update($order, $data);

        $data = OrderResource::make($order);

        return $this->sendResponse($data, 'success');
    }

    public function cancel(CancelOrderRequest $request, Order $order)
    {
        $data = $request->validated();

        $order = $this->repository->update($order, $data);

        $data = OrderResource::make($order);


        event(new UpdateOrderStatusEvent($order));


        return $this->sendResponse($data, 'success');
    }


    public function uploadMedia(UploadMediaRequest $request)
    {
        $data = $request->validated();

        $media = $this->repository->uploadMedia($data);

        return $this->sendResponse($media, 'success');
    }

    public function rate(OrderRateRequest $request, Order $order)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $this->repository->rate($order, $data);

            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();
            $message = $th->getMessage();
            return $this->sendErrorData(["error" => [$message]], $message);
        }

        return $this->sendSuccess('Rated successfully');
    }
}
