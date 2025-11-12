<?php

namespace App\Services\PaymentGateways;

use App\Enums\OrderStatusEnum;
use Carbon\Carbon;
use Exception;
use Http;
use Illuminate\Http\Exceptions\HttpResponseException;
use Log;
use Modules\Orders\Entities\Order;
use Modules\Orders\Events\UpdateOrderStatusEvent;
use Modules\Support\Traits\ApiTrait;
use Modules\Support\Traits\consumeExternalServices;

class MyfatoorahService
{
    use consumeExternalServices, ApiTrait;

    protected $baseUri;
    protected $app_key;

    public function __construct()
    {
        $this->baseUri = config('payment-gateways.myfatoorah.base_uri');
        $this->app_key = config('payment-gateways.myfatoorah.app_key');
    }

    // to resolve the autorization
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    // create the access token
    public function resolveAccessToken()
    {
        return "Bearer {$this->app_key}";
    }

    // resolve the factor (to solve zero decimal currency problem)
    public function resolveFactor($currency)
    {
        $zeroDecimalCurrencies = ['JPY'];

        if (in_array(strtoupper($currency), $zeroDecimalCurrencies)) {
            return 1;
        }
        return 100;
    }

    // to decode the response of the sent request
    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    // send a payment
    public function sendPayment($name, $phone = null, $email, $value, $currency  , $order)
    {

        $userDefinedField = json_encode([
            "order_id" => $order->id
        ]);

        try {
            $req = $this->makeRequest(
                'POST',
                '/v2/SendPayment',
                [],
                [
                    "CustomerName" => $name,
                    "UserDefinedField" => $userDefinedField,
                    "NotificationOption" => "LNK",
                    "CustomerEmail" => $email,
                    "InvoiceValue" => round($value * $factor = $this->resolveFactor($currency)) / $factor,
                    "DisplayCurrencyIso" => strtoupper($currency),
                    "CallBackUrl" => route('myFatorahApproval'),
                    "ErrorUrl" => route('myFatorahCancel'),
                    "Language" => "en",
                ],
                [],
                $isJsonRequest = true
            );
        } catch (\Throwable $th) {

            if ($th->getResponse()) {
                $decodeResponse = json_decode($th->getResponse()->getBody()->getContents(), true);
                $ResponseErrors = data_get($decodeResponse, 'ValidationErrors', [['Error' => 'payment has error']]);
                $errors = collect($ResponseErrors)->pluck('Error')->toArray();

                throw new HttpResponseException($this->sendErrorData(['error' => $errors], data_get($errors, 0, 'payment has error')));
            }

            $message = 'payment has error';
            throw new HttpResponseException($this->sendErrorData(['error' => [$message]], $message));
        }

        return $req;
    }

    // pay
    public function pay($data): void
    {
        if (isset($data["invoice_id"], $data["payment_id"])) {
            try {
                $payment_status = $this->getPaymentStatus($data["payment_id"]);
                $payment = collect($payment_status->Data);
                if ($payment['InvoiceStatus'] != "Paid") {
                    $message = trans("orders::validation.this order has problem with payment");
                    throw new HttpResponseException($this->sendErrorData(["error" => [$message]], $message));
                }
            } catch (\Throwable $th) {
                $message = trans("orders::validation.this order has problem with payment");
                throw new HttpResponseException($this->sendErrorData(["error" => [$message]], $message));
            }
        }
    }

    // get payment status
    public function getPaymentStatus($invoice_id, $KeyType = 'PaymentId')
    {

        $keyId = $invoice_id;
        return $this->makeRequest(
            'POST',
            '/v2/getPaymentStatus',
            [],
            [
                'Key' => $keyId,
                'KeyType' => $KeyType
            ],
            [],
            $isJsonRequest = true
        );
    }

    // handle the approval of the payment
    public function handleApproval()
    {
        if (request('paymentId')) {
            $payment_status = $this->getPaymentStatus(request('paymentId'));
            $payment = collect($payment_status->Data);
            if ($payment['InvoiceStatus'] == "Paid") {
                // buyer name
                $buyername = $payment['CustomerName'];
                // get amount and currency code
                $amount = $payment['InvoiceDisplayValue'];
                // date and time of the payment
                $date = Carbon::parse($payment['CreatedDate'])->format('d/m/Y h:i A');

                $order = Order::withoutGlobalScopes(["notPrePaid"])->find( json_decode($payment["UserDefinedField"])->order_id);

                $order->update([
                    'payment_id' => request('paymentId'),
                    'status' => OrderStatusEnum::PENDING->value,
                ]);

                event(new UpdateOrderStatusEvent($order->refresh()));

                return redirect()->route('pay.accept.form', ['invoiceId' => $payment['InvoiceId'], 'paymentId' => request('paymentId')])->withSuccess("Thanks, {$buyername}. We received your {$amount} payment at {$date}.");
            }
        }

        return redirect()->route('pay.form')->withErrors('The payment process no compeleted, please try again');
    }


    public function getPaymentUrl($name, $phone, $email, $value, $currency, $package_id)
    {
        $data = $this->sendPayment($name, $phone, $email, $value, $currency, $package_id);

        return [
            'ref_id' => collect($data->Data)['InvoiceURL'],
        ];
    }

    public function checkPaymentStatus($invoice_id, $invoice = 'invoiceid')
    {
        $payment_status = $this->getPaymentStatus($invoice_id, $invoice);
        $payment = collect($payment_status->Data);
        if ($payment['InvoiceStatus'] != "Paid") {
            $message = trans("orders::validation.this order has problem with payment");
            throw new HttpResponseException($this->sendErrorData(["error" => [$message]], $message));
        }
        return true;
    }
    public function processPayment($order, $payment)
    {
        $paymentMethodId = $payment;
        $paymentRequest = [
            'InvoiceValue' => $order->total,
            'CustomerName' => $order->user->name,
            'CustomerEmail' => $order->user->email,
            'CustomerMobile' => $order->user->phone,
            'PaymentMethodId' => $paymentMethodId,
            'CallBackUrl' => route('authorized.url'),
            'ErrorUrl' => route('declined.url'),
            'Language' => 'EN', // or 'AR'
            "NotificationOption" => "LNK"
        ];
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('payment-gateways.myfatoorah.app_key'),
            ])->post(config('payment-gateways.myfatoorah.base_uri') . '/v2/SendPayment', $paymentRequest);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['Data'])) {
                return [
                    'invoice_url' => $responseData['Data']['InvoiceURL'],
                    'invoiceId' => $responseData['Data']['InvoiceId'],
                ];
            }

            Log::error('MyFatoorah API failed', ['response' => $responseData]);
            throw new Exception('Payment processing failed. Please check MyFatoorah response.');
        } catch (Exception $e) {
            Log::error('MyFatoorah payment error', ['message' => $e->getMessage()]);
            return null;
        }
    }




    public function makeRefund($invoiceId, $amount)
    {
        try {
            $req = $this->makeRequest(
                'POST',
                '/v2/MakeRefund',
                [],
                [
                    "Key" => $invoiceId,
                    "KeyType" => "InvoiceId",
                    "RefundChargeOnCustomer" => false,
                    "ServiceChargeOnCustomer" => false,
                    "Amount" => $amount,
                    "Comment" => "test comment",
                    "CurrencyIso" => "SAR"
                ],
                [],
                $isJsonRequest = true
            );
        } catch (\Throwable $th) {

            // if ($th->getResponse()) {
            //     $decodeResponse = json_decode($th->getResponse()->getBody()->getContents(), true);
            //     $ResponseErrors = data_get($decodeResponse, 'ValidationErrors', [['Error' => 'payment has error']]);
            //     $errors = collect($ResponseErrors)->pluck('Error')->toArray();

            //     throw new HttpResponseException($this->sendErrorData(['error' => $errors], data_get($errors, 0, 'payment has error')));
            // }

            // $message = 'payment has error';
            // throw new HttpResponseException($this->sendErrorData(['error' => [$message]], $message));

            return;
        }

        return $req;
    }

    // get payment status
    public function getRefundStatus($keyId, $KeyType = 'InvoiceId')
    {
        try {
            return $this->makeRequest(
                'POST',
                '/v2/GetRefundStatus',
                [],
                [
                    'Key' => $keyId,
                    'KeyType' => $KeyType
                ],
                [],
                $isJsonRequest = true
            );
        } catch (\Throwable $th) {

            return false;
        }
    }
}
