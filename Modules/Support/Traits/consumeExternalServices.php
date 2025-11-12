<?php

namespace Modules\Support\Traits;


use GuzzleHttp\Client;

trait consumeExternalServices
{
    public function makeRequest($method, $requestUrl, $queryParams = [], $formParams = [], $headers = [], $isJsonRequest = false)
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->baseUri,
        ]);

        // check if this method is existed
        if (method_exists($this, 'resolveAuthorization')) {
            // resolve the authorization
            $this->resolveAuthorization($queryParams, $formParams, $headers);
        }

        // make a request
        $response = $client->request($method, $requestUrl, [
            $isJsonRequest ? 'json' : 'form_params' => $formParams,
            'headers' => $headers,
            'query' => $queryParams
        ]);

        // get the content of the response of the sent request
        $response = $response->getBody()->getContents();

        // check if this method is existed
        if (method_exists($this, 'decodeResponse')) {
            // decode the response of the sent request
            $response = $this->decodeResponse($response);
        }

        return $response;
    }
}
