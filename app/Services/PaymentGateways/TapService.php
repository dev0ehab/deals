<?php

namespace App\Services\PaymentGateways;

use Illuminate\Http\Request;
use Modules\Support\Traits\ApiTrait;
use Modules\Support\Traits\consumeExternalServices;

class TapService
{
    use consumeExternalServices, ApiTrait;

    protected $baseUri;
    protected $secret_key;
    protected $public_key;

    public function __construct()
    {
        $this->baseUri = config('payment-gateways.tap.base_uri');
        $this->secret_key = config('payment-gateways.tap.secret_key');
        $this->public_key = config('payment-gateways.tap.public_key');
    }

    // to resolve the autorization
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    // create the access token
    public function resolveAccessToken()
    {
        return "Bearer {$this->secret_key}";
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
    public function sendPayment($name, $email, $value, $currency)
    {
        return $this->makeRequest(
            'POST',
            '/v2/charges',
            [],
            [
                "customer" => [
                    "first_name" => $name,
                    "email" => $email,
                    // "phone" => [
                    //     "country_code" => 965,
                    //     "number" => 51234567
                    // ]
                ],
                "source" => [
                    "id" => "src_card",
                    // "id" => "src_all",
                ],
                "amount" => round($value * $factor = $this->resolveFactor($currency)) / $factor,
                "currency" => strtoupper($currency),
                "redirect" => [
                    "url" => route('callback.url')
                ],
            ],
            [],
            $isJsonRequest = true
        );
    }

    // handel the payment
    public function handlePayment(Request $request)
    {
        $name = $request->user()->name;
        $email = "business@media.com";
        // create order
        $order = $this->sendPayment($name, $email, $request->amount, $request->currency);

        if ($order->status == "INITIATED") {
            // get approve link
            $approval_link = $order->transaction->url;
            // redirect to the approve link
            return [
                'payment_id' => $order->id,
                'approval_link' => $approval_link,
            ];
        }

        return $this->sendError('We can not complete the payment process, please try again');
    }

    // get payment status
    public function getPaymentStatus($charge_id)
    {
        return $this->makeRequest(
            'GET',
            "/v2/charges/{$charge_id}",
            [],
            [],
            [],
            $isJsonRequest = true
        );
    }

    // handle the approval of the payment
    public function handleApproval($charge_id)
    {
        $payment = $this->getPaymentStatus($charge_id);

        if ($status =  $payment->status == "CAPTURED") {
            return [
                'status' => $status,
                'id' => $payment->id,
            ];
        }else{
            return [
                'status' => $status,
                'message' => $payment->response->message,
                'code' => $payment->response->code
            ];
        }

    }
}
