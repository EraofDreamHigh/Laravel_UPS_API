<?php

namespace App\Http\Transporters\Requests;

interface TransporterRequestInterface {
    /**
     * @param string $endPoint
     * @param array $payload
     * @return mixed
     */
    public function get(string $endPoint, array $payload);

    /**
     * @param string $endPoint
     * @param array $payload
     * @return mixed
     */
    public function post(string $endPoint, array $payload);
}