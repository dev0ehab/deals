<?php

namespace App\Services\PaymentGateways;

use Illuminate\Http\Request;
use Modules\Support\Traits\consumeExternalServices;

class VapulusService
{
    use consumeExternalServices;

    protected $baseUri;
    protected $appId;
    protected $password;
    protected $hash;

    public function __construct()
    {
        $this->baseUri = config('payment-gateways.vapulus.base_uri');
        $this->appId = config('payment-gateways.vapulus.app_id');
        $this->password = config('payment-gateways.vapulus.password');
        $this->hash = config('payment-gateways.vapulus.hash');
    }

    // // to resolve the autorization
    // public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    // {
    //     $headers['Authorization'] = $this->resolveAccessToken();
    // }

    // // create the access token
    // public function resolveAccessToken()
    // {
    //     $credentials = base64_encode("{$this->clientId}:{$this->clientSecret}");
    //     return "Basic {$credentials}";
    // }

    // generate hash secret
    function generateHash($postData)
    {
        ksort($postData);
        $message = "";
        $appendAmp = 0;
        foreach ($postData as $key => $value) {
            if (strlen($value) > 0) {
                if ($appendAmp == 0) {
                    $message .= $key . '=' . $value;
                    $appendAmp = 1;
                } else {
                    $message .= '&' . $key . "=" . $value;
                }
            }
        }
        $secret = pack('H*', $this->hash);
        return hash_hmac('sha256', $message, $secret);
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
    public function createCard($cardNum, $cardExp, $cardCVC, $holderName, $mobile, $email)
    {
        $data = [
            "cardNum" => $cardNum,
            "cardExp" => $cardExp,
            "cardCVC" => $cardCVC,
            "holderName" => $holderName,
            "mobileNumber" => $mobile,
            "email" => $email
        ];

        $hashSecret = $this->generateHash($data);

        return $this->makeRequest(
            'POST',
            '/app/addCard',
            [],
            [
                "appId" => $this->appId,
                "password" => $this->password,
                "hashSecret" => $hashSecret,
                "cardNum" => $cardNum,
                "cardExp" => $cardExp,
                "cardCVC" => $cardCVC,
                "holderName" => $holderName,
                "mobileNumber" => $mobile,
                "email" => $email,
            ],
            [],
            $isJsonRequest = true
        );
    }

    // handel the payment
    public function handlePayment(Request $request)
    {
    }

    // handle the approval of the payment
    public function handleApproval()
    {
    }
}
