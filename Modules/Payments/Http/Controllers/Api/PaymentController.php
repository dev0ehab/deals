<?php

namespace Modules\Payments\Http\Controllers\Api;

use App\Services\PaymentGateways\MyfatoorahService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Support\Traits\ApiTrait;
class PaymentController extends Controller
{
    use ApiTrait;

    private $service;

    public function __construct(MyfatoorahService $service)
    {
        $this->service = $service;
    }

    public function callback(Request $request)
    {
            // $paymentId = $request->input('paymentId');
            // if (!$paymentId) {
            //     return $this->sendError('Payment ID not provided.');
            // }

            // $myFatoorahService = app(MyfatoorahService::class);
            // $paymentStatus = $myFatoorahService->getPaymentStatus($paymentId , 'PaymentId');
            // if ($paymentStatus) {
            //     $InvoiceId = $paymentStatus->Data->InvoiceId;
            //     $order = Order::withoutGlobalScope(OrderGlobalScope::class)->where('invoice_id', $InvoiceId)->first();
            //     $order->status =  OrderStatusEnum::Pending->value;
            //     $order->payment_id = $paymentId;
            //     $order->save();
            //     CartItem::whereIn('product_variance_id', $order->items->pluck('product_variance_id'))
            //             ->where('cart_id', $order->user->cart->id)
            //             ->delete();
            //     return $myFatoorahService->handleApproval();
            // }

            return $this->sendError('An error occurred while processing payment.');
    }


    public function declined()
    {
        return redirect()->route('pay.form')->withErrors('The payment process no compeleted, please try again');
    }
}
