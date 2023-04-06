<?php

namespace App\Http\Transporters\Rules;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Responses\TransporterResponseInterface;

interface TransporterHasRatesInterface
{
    /**
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function getRates(TransporterBaseData $data): TransporterResponseInterface;
}
