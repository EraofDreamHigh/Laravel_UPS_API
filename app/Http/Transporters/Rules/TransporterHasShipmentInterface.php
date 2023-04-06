<?php

namespace App\Http\Transporters\Rules;

use App\Http\Transporters\Data\ShipmentColli;
use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Responses\TransporterResponseInterface;

interface TransporterHasShipmentInterface
{
    /**
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function createShipment(TransporterBaseData $data): TransporterResponseInterface;
}