<?php

namespace App\Services\PaymentGateways;

use Illuminate\Http\Request;
use Modules\Support\Traits\consumeExternalServices;

class PaypalService
{
    use consumeExternalServices;

    protected $baseUri;
    protected $clientId;
    protected $clientSecret;
    protected $plans;

    public function __construct()
    {
        $this->baseUri = config('payment-gateways.paypal.base_uri');
        $this->clientId = config('payment-gateways.paypal.client_id');
        $this->clientSecret = config('payment-gateways.paypal.client_secret');
        $this->plans = config('payment-gateways.paypal.plans');
    }

    // to resolve the autorization
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    // create the access token
    public function resolveAccessToken()
    {
        $credentials = base64_encode("{$this->clientId}:{$this->clientSecret}");
        return "Basic {$credentials}";
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

    // create an order
    public function createOrder($value, $currency)
    {
        return $this->makeRequest(
            'POST',
            '/v2/checkout/orders',
            [],
            [
                "intent" => "CAPTURE",
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => strtoupper($currency),
                            "value" => round($value * $factor = $this->resolveFactor($currency)) / $factor
                        ]
                    ]
                ],
                "application_context" => [
                    "brand_name" => env('APP_NAME'),
                    "shipping_preference" => "NO_SHIPPING",
                    "user_action" => "PAY_NOW",
                    "return_url" => route('approval'),
                    "cancel_url" => route('cancelled'),
                ]
            ],
            [],
            $isJsonRequest = true
        );
    }

    // capture the payment
    public function capturePayment($approvalId)
    {
        return $this->makeRequest(
            'POST',
            "/v2/checkout/orders/{$approvalId}/capture",
            [],
            [],
            [
                "Content-Type" => "application/json"
            ],
        );
    }

    // handel the payment
    public function handlePayment(Request $request)
    {
        // create order
        $order = $this->createOrder($request->value, $request->currency);
        // get order links
        $orderLinks = collect($order->links);
        // get approve link
        $approve = $orderLinks->where('rel', 'approve')->first();
        // put approve id in session
        session()->put('approvalId', $order->id);
        // redirect to the approve link
        return redirect($approve->href);
    }

    // handle the approval of the payment
    public function handleApproval()
    {
        if (session()->has('approvalId')) {
            // get approvalId from session
            $approvalId = session()->get('approvalId');
            // capture the payment
            $payment = $this->capturePayment($approvalId);
            // buyer name
            $buyer = $payment->payer->name;
            $buyername = $buyer->given_name . ' ' . $buyer->surname;
            // get amount and currency code
            $payment_details = $payment->purchase_units[0]->payments->captures[0]->amount;
            // amount
            $amount = $payment_details->value;
            // currency code
            $currency_code = $payment_details->currency_code;

            return redirect()->route('pay.form')->withSuccess(['payment' => "Thanks, {$buyername}. We received your {$amount} {$currency_code} payment."]);
        }
        return redirect()->route('pay.form')->withErrors('We can not capture the payment, please try again');
    }


    /** Subscription functions **/

    // handle the subscription to one plan
    public function handleSubscription(Request $request)
    {
        $subscription = $this->createSubscription(
            $request->plan,
            $request->user()->name,
            $request->user()->email,
        );

        // get subscription links
        $subscriptionLinks = collect($subscription->links);
        // get approve link
        $approve = $subscriptionLinks->where('rel', 'approve')->first();
        // put approve id in session
        session()->put('subscriptionId', $subscription->id);
        // redirect to the approve link
        return redirect($approve->href);
    }

    // create a subscription
    public function createSubscription($planSlug, $name, $email)
    {
        $return_url = route('subscribe.approval', ['plan' => $planSlug]);
        $cancel_url = route('subscribe.cancelled');

        return $this->makeRequest(
            'POST',
            '/v1/billing/subscriptions',
            [],
            [
                "plan_id" => $this->plans[$planSlug],
                "subscriber" => [
                    "name" => [
                        "given_name" => $name
                    ],
                    "email_address" => $email
                ],
                "application_context" => [
                    "brand_name" => env('APP_NAME'),
                    "shipping_preference" => "NO_SHIPPING",
                    "user_action" => "SUBSCRIBE_NOW",
                    "return_url" => $return_url,
                    "cancel_url" => $cancel_url
                ]
            ],
            [],
            $isJsonRequest = true
        );
    }

    // validate subscription
    public function validateSubscription(Request $request)
    {
        if (session()->has('subscriptionId')) {
            $subscriptionId = session()->get('subscriptionId');
            // forget subscription id in the session
            session()->forget('subscriptionId');
            return $request->subscription_id == $subscriptionId;
        }
        return false;
    }
}
