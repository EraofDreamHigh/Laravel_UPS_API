<?php

namespace App\Http\Transporters\Services\UPS;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Rules\TransporterHasRatesInterface;
use App\Http\Transporters\Responses\TransporterResponseInterface;
use App\Http\Transporters\Services\UPS\Document\Request as DocumentRequest;
use App\Http\Transporters\Services\UPS\Rate\Request as RateRequest;
use App\Http\Transporters\Services\UPS\FreightRate\Request as FreightRateRequest;
use App\Http\Transporters\Services\UPS\Shipment\Request as ShipmentRequest;
use App\Http\Transporters\Services\UPS\Pickup\Request as PickupRequest;
use App\Http\Transporters\Services\UPS\Track\Request as TrackRequest;

class UPS implements TransporterHasRatesInterface
{

    /**
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function getRates(TransporterBaseData $data): TransporterResponseInterface {
        return (new RateRequest($data))->execute();
    }

	/**
     * @param TransporterBaseData $data
     * @return TransporterResponseInterface
     */
    public function getFreightRates(TransporterBaseData $data): TransporterResponseInterface {
        return (new FreightRateRequest($data))->execute();
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
	public function createPickup(TransporterBaseData $data): TransporterResponseInterface
	{
		return (new PickupRequest($data))->execute();
	}

	/**
	 * @param TransporterBaseData $data
	 * @return TransporterResponseInterface
	 */
	public function uploadDocument(TransporterBaseData $data): TransporterResponseInterface
	{
		return (new DocumentRequest($data))->execute();
	}

	/**
	 * @param TransporterBaseData $data
	 * @param $document_id
	 * @param $shipment_id
	 * @return TransporterResponseInterface
	 */
	public function connectDocument(TransporterBaseData $data, $document_id, $shipment_id): TransporterResponseInterface
	{
		return (new DocumentRequest($data))->executeConnect($document_id, $shipment_id);
	}

	/**
	 * @param TransporterBaseData $data
	 * @return TransporterResponseInterface
	 */
	public function getTrack(TransporterBaseData $data): TransporterResponseInterface
	{
		return (new TrackRequest($data))->execute();
	}

}
