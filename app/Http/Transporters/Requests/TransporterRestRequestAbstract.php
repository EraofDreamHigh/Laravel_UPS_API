<?php

namespace App\Http\Transporters\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

abstract class TransporterRestRequestAbstract extends TransporterRequestAbstract
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * TransporterSoapRequestAbstract constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        parent::__construct();

        $this->client = new Client($options);
    }

    /**
     * @param string $endPoint
     * @param array $payload
     * @return mixed
     */
    public function get(string $endPoint, array $payload)
    {
        return $this->client->get($endPoint, $payload)->getBody()->getContents();
    }

    /**
     * @param string $endPoint
     * @param array $payload
     * @return mixed
     */
    public function post(string $endPoint, array $payload = [], array $headers = [])
    {
        return $this->client->post($endPoint, [
            'headers' => $headers,
            'json' => $payload
        ])->getBody()->getContents();
        //  return $this->client->post($endPoint, $payload)->getBody()->getContents();
    }

    /** PUT
     * @param string $endPoint
     * @param array $payload
     * @return mixed
     */
    public function put(string $endPoint, array $payload, array $headers = [])
    {
        return $this->client->put($endPoint, [
            'headers' => $headers,
            'json' => $payload
        ])->getBody()->getContents();
        //  return $this->client->put($endPoint, $payload)->getBody()->getContents();
    }


    /**
     * @param string $endPoint
     * @param array $payload
     * @return mixed
     */
    public function postUri(string $endPoint, array $payload)
    {
        $uri = new Uri($endPoint);

        return $this->client->post($uri->withQuery(http_build_query($payload['body'])), [
            'headers' => $payload['headers']
        ])->getBody()->getContents();
    }

    abstract public function execute();
}