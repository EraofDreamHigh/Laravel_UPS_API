<?php

namespace App\Http\Transporters\Services\Fedex\Traits;

Trait getTokenTrait
{

    private int $retries = 0;

    /**
     * @return string
     */
    public function getToken($authKey, $authSecret) : string {

        if (session('fedex_token') && session('fedex_token_expires') > time()) {
           return session('fedex_token');
        }

        //throw new \Exception('Key:' . json_encode( [$authKey, $authSecret] ));

        $options = [
            'http_errors' => false,
	        'verify' => false,
            'timeout' => 60,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $authKey,
                'client_secret' => $authSecret,
                //'client_id' => 'l7be3d76e7300b41378988a29bdc53ea46',
                //'client_secret' => 'db2952b09db141acafd750e242646cfb',
            ]
        ];

        $client = new \GuzzleHttp\Client();
        $url = 'https://apis-sandbox.fedex.com/oauth/token';

        $result = $client->request('POST', $url, $options);

        $token = json_decode( $result->getBody()->getContents() );
        
        if (isset( $token->access_token )){
            session(['fedex_token' => $token->access_token]);
            session(['fedex_token_expires' => time() + $token->expires_in]);
            return $token->access_token;
        }

        if ($this->retries < 3) {
            $this->retries++;
            return $this->getToken($authKey, $authSecret);
        }

        throw new \Exception('Access token could not be received' . json_encode( $token ));

    }

}