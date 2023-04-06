<?php

namespace App\Http\Transporters\Services\UPS\Pickup;

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
        	'PickupCreationRequest' => [
	            'Request' => [
					'RequestOption' => 1
		        ],
		        'RatePickupIndicator' => 'N',
		        'Shipper' => [
		            'Account' => [
						'AccountNumber' => ($this->data->getExw()) ? $this->data->getExwAccount() : $this->data->getAccountNumber(),
						'AccountCountryCode' => ($this->data->getExw()) ? $this->data->getShipmentExwAddress()->getCountryCode("ups") : 'NL',
			        ]
		        ],
		        'PickupDateInfo' => [
		            'PickupDate' => date('Ymd', strtotime($this->data->getShipmentPickupDate())),
		            'ReadyTime' => date('Hi', strtotime($this->data->getShipmentPickupTimeStart())),
		            'CloseTime' => date('Hi', strtotime($this->data->getShipmentPickupTimeUntil())),
		        ],
		        'PickupAddress' => [
			        'CompanyName' => substr($this->data->getShipmentShipper()->getCompany(),0,27),
			        'ContactName' => substr($this->data->getShipmentShipper()->getName(),0,22),
			        'AddressLine' => $this->data->getShipmentShipper()->getStreetLines() . ' ' . ($this->data->getShipmentShipper()->getStreetLines(1) ?? ''),
			        'City' => $this->data->getShipmentShipper()->getCity("ups"),
			        'StateProvince' => $this->data->getShipmentShipper()->getStateOrProvinceCode(),
			        'PostalCode' => $this->data->getShipmentShipper()->getZip(),
			        'CountryCode' => $this->data->getShipmentShipper()->getCountryCode("ups"),
			        'ResidentialIndicator' => ($this->data->getShipmentShipper()->getIsPrivate() ? 'Y' : 'N'),
			        'PickupPoint' => substr($this->data->getShipmentPickupInstructions(),0,10),
			        'Phone' => [
			            'Number' => substr($this->data->getShipmentShipper()->getPhone(), 4),
			            'Extension' => substr($this->data->getShipmentShipper()->getPhone(), 0, 4),
			        ]
		        ],
		        'AlternateAddressIndicator' => 'Y',
		        'PickupPiece' => [
		            'ServiceCode' => '011', 
		            'Quantity' => $this->getTotalCollies(),
		            'DestinationCountryCode' => $this->data->getShipmentRecipient()->getCountryCode("ups"),
		            'ContainerCode' => '01',
		        ],
		        'TotalWeight' => [
		            'Weight' => $this->getTotalColliWeight(),
		            'UnitOfMeasurement' => 'KGS',
		        ],
		        'OverweightIndicator' => $this->getOverWeight(),
		        'PaymentMethod' => '01',
		        'SpecialInstruction' => $this->data->getShipmentPickupInstructions(),
		        'ReferenceNumber' => $this->data->getShipmentReference(),
	        ]
        ];

        return $data;
    }
}
