<?php

namespace App\Http\Transporters\Transformers;

use App\Http\Transporters\Data\TransporterBaseData;

class TransporterTransformerBase
{
    /**
     * @var array
     */
    protected $data;

    /**
     * TransportTransformerAbstract constructor.
     * @param TransporterBaseData $data
     */
    public function __construct(TransporterBaseData $data)
    {
        $this->data = $data;
    }
}