<?php

namespace App\Http\Transporters\Services\Fedex;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Rules\TransporterHasRatesInterface;
use App\Http\Transporters\Rules\TransporterHasShipmentInterface;
use App\Http\Transporters\Responses\TransporterResponseInterface;
use App\Http\Transporters\Services\Fedex\Rate\Request as RateRequest;
use App\Http\Transporters\Services\Fedex\Track\Request as TrackRequest;
use App\Http\Transporters\Services\Fedex\Pickup\Request as PickupRequest;
use App\Http\Transporters\Services\Fedex\Shipment\Request as ShipmentRequest;
use App\Http\Transporters\Services\Fedex\Document\Request as DocumentRequest;

class Fedex implements TransporterHasRatesInterface, TransporterHasShipmentInterface
{
    /**
     * @docs https://developer.fedex.com/api/nl-nl/catalog/rate/v1/docs.html#operation/Rate%20and%20Transit%20times
     * @endpoint /rate/v1/rates/quotes
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function getRates(TransporterBaseData $data): TransporterResponseInterface {
        return (new RateRequest($data))->execute();
    }

    /**
     * @docs https://developer.fedex.com/api/nl-nl/catalog/ship/v1/docs.html
     * @endpoint /ship/v1/shipments
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function createShipment(TransporterBaseData $data): TransporterResponseInterface
    {
        return (new ShipmentRequest($data))->execute();
    }

    /**
     * @docs https://developer.fedex.com/api/nl-nl/catalog/pickup/v1/docs.html#operation/Create%20Pickup
     * @endpoint /pickup/v1/pickups
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function createPickup(TransporterBaseData $data): TransporterResponseInterface
    {
        return (new PickupRequest($data))->execute();
    }

    /**
     * @docs https://developer.fedex.com/api/nl-nl/catalog/track/v1/docs.html#operation/Track%20by%20Tracking%20Number
     * @endpoint /track/v1/trackingnumbers
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function getTrack(TransporterBaseData $data): TransporterResponseInterface
    {
        return (new TrackRequest($data))->execute();
    }
    

    /**
     * @docs https://developer.fedex.com/api/nl-nl/catalog/upload-documents/v1/docs.html#operation/Upload%20ETD%20files
     * @endpoint /documents/v1/etds/upload
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function uploadDocument(TransporterBaseData $data): TransporterResponseInterface
    {
        return (new DocumentRequest($data))->execute();
    }
}
