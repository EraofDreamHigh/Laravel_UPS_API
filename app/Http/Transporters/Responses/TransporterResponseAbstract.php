<?php

namespace App\Http\Transporters\Responses;

abstract class TransporterResponseAbstract implements TransporterResponseInterface
{
    /**
     * @param string $xml
     * @return mixed
     */
    protected function xmlToObject(string $xml)
    {
        return json_decode(json_encode(simplexml_load_string($xml, null, LIBXML_NOCDATA)), false);
    }
}