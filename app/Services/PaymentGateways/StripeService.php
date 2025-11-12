<?php

namespace App\Services\PaymentGateways;

use Illuminate\Http\Request;
use Modules\Support\Traits\consumeExternalServices;

class StripeService
{
    use consumeExternalServices;

    protected $baseUri;
    protected $key;
    protected $secret;
    protected $plans;

    public function __construct()
    {
        $this->baseUri = config('payment-gateways.stripe.base_uri');
        $this->key = config('payment-gateways.stripe.key');
        $this->secret = config('payment-gateways.stripe.secret');
        $this->plans = config('payment-gateways.stripe.plans');
    }

    // to resolve the autorization
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    // create the access token
    public function resolveAccessToken()
    {
        return "Bearer {$this->secret}";
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

    // handel the payment
    public function handlePayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required'
        ]);
        // create intent
        $intent = $this->createIntent($request->value, $request->currency, $request->payment_method);
        // put payment intent id in the session
        session()->put('paymentIntentId', $intent->id);
        return redirect()->route('approval');
    }

    // create intent
    public function createIntent($value, $currency, $paymentMethod)
    {
        return $this->makeRequest(
            'POST',
            '/v1/payment_intents',
            [],
            [
                'amount' => round($value * $this->resolveFactor($currency)),
                'currency' => strtolower($currency),
                'payment_method' => $paymentMethod,
                'confirmation_method' => 'manual',

            ],
        );
    }

    // confirm payment
    public function confirmPayment($paymentIntentId)
    {
        return $this->makeRequest(
            'POST',
            "/v1/payment_intents/{$paymentIntentId}/confirm"
        );
    }

    // handle the approval of the payment
    public function handleApproval()
    {
        if (session()->has('paymentIntentId')) {
            // get approvalId from session
            $paymentIntentId = session()->get('paymentIntentId');
            // confirm the payment
            $confirmation = $this->confirmPayment($paymentIntentId);

            // check if the confirmation require any actions
            if ($confirmation->status === "requires_action") {
                // get client secret
                $clientSecret = $confirmation->client_secret;
                return view('paymentgateway::stripe.3d-secure')->with(['clientSecret' => $clientSecret]);
            }


            if ($confirmation->status === "succeeded") {
                $buyername = $confirmation->charges->data[0]->billing_details->name;
                $currency_code = strtoupper($confirmation->currency);
                $amount = $confirmation->amount / $this->resolveFactor($currency_code);
                return redirect()->route('pay.form')->withSuccess(['payment' => "Thanks, {$buyername}. We received your {$amount} {$currency_code} payment."]);
            }
        }
        return redirect()->route('pay.form')->withErrors('We can not capture the payment, please try again');
    }



    /** Subscription functions **/

    // handle the subscription to one plan
    public function handleSubscription(Request $request)
    {
        // create customer
        $customer = $this->createCustomer(
            $request->user()->name,
            $request->user()->email,
            $request->payment_method,
        );

        // make subscription
        $subscription = $this->createSubscription(
            $customer->id,
            $request->payment_method,
            $this->plans[$request->plan]
        );

        if ($subscription->status == "active") {
            // for validation
            session()->put('subscriptionId', $subscription->id);
            return redirect()->route('subscribe.approval', [
                'plan' => $request->plan,
                'subscription_id' => $subscription->id
            ]);
        }

        // get payment intent
        $paymentIntent = $subscription->latest_invoice->payment_intent;
        // check if the confirmation require any actions
        if ($paymentIntent->status === "requires_action") {
            // for validation
            session()->put('subscriptionId', $subscription->id);
            // get client secret
            $clientSecret = $paymentIntent->client_secret;
            return view('paymentgateway::stripe.3d-secure-subscription')->with([
                'clientSecret' => $clientSecret,
                'plan' => $request->plan,
                'paymentMethod' => $request->payment_method,
                'subscriptionId' => $subscription->id
            ]);
        }

        return redirect()->route('subscribe.show')->withErrors('We are unable to activate the subscription, please try again');
    }

    // create customer
    public function createCustomer($name, $email, $paymentMethod)
    {
        return $this->makeRequest(
            "POST",
            "/v1/customers",
            [],
            [
                "name" => $name,
                "email" => $email,
                "payment_method" => $paymentMethod
            ],
        );
    }

    // create a subscription
    public function createSubscription($customerId, $paymentMethod, $priceId)
    {
        return $this->makeRequest(
            "POST",
            "/v1/subscriptions",
            [],
            [
                "customer" => $customerId,
                "items" => [
                    ['price' => $priceId]
                ],
                "default_payment_method" => $paymentMethod,
                "expand" => ["latest_invoice.payment_intent"],
            ],
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
