<?php

namespace App\Http\Transporters\Services\TNT;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Rules\TransporterHasRatesInterface;
use App\Http\Transporters\Rules\TransporterHasShipmentInterface;
use App\Http\Transporters\Responses\TransporterResponseInterface;
use App\Http\Transporters\Services\TNT\Rate\Request as RateRequest;
use App\Http\Transporters\Services\TNT\Track\Request as TrackRequest;
use App\Http\Transporters\Services\TNT\Label\Request as LabelRequest;
use App\Http\Transporters\Services\TNT\Pickup\Request as PickupRequest;
use App\Http\Transporters\Services\TNT\Shipment\Request as ShipmentRequest;

class TNT implements TransporterHasRatesInterface, TransporterHasShipmentInterface
{
    /**
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function getRates(TransporterBaseData $data): TransporterResponseInterface
    {
        return (new RateRequest($data))->execute();
    }

    /**
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function createShipment(TransporterBaseData $data): TransporterResponseInterface
    {
        return (new ShipmentRequest($data))->execute();
    }

    /**
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function getPickup(TransporterBaseData $data): TransporterResponseInterface
    {
        return (new PickupRequest($data))->execute();
    }

    /**
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function getTrack(TransporterBaseData $data): TransporterResponseInterface
    {
        return (new TrackRequest($data))->execute();
    }

    /**
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function getLabel(TransporterBaseData $data): TransporterResponseInterface
    {
        return (new LabelRequest($data))->execute();
    }

}