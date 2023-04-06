<?php

namespace App\Http\Transporters\Services\UPS\FreightRate;

use App\Http\Transporters\Services\UPS\UPSBaseResource;
use App\Http\Transporters\Rules\TransporterMustTransformInterface;

class Resource extends UPSBaseResource implements TransporterMustTransformInterface
{
    /**
     * Transform method
     * @return mixed
     */
    public function transform(): array
    {
        $data = [
			'FreightRateRequest":' => [
				'Request' => [
					'RequestOption' => 'Shop',
				],
				'ShipFrom' => [
					'Address' => [
						'PostalCode' => $this->data->getShipmentShipper()->getZip(),
						'CountryCode' => $this->data->getShipmentShipper()->getCountryCode(),
					],
				],
			],
        ];

        return $data;
    }
}
