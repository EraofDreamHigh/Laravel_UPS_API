<?php

namespace App\Http\Transporters\Services\Fedex\Pickup;

use App\Http\Transporters\Services\Fedex\FedexBaseResource;
use App\Http\Transporters\Rules\TransporterMustTransformInterface;

class Resource extends FedexBaseResource implements TransporterMustTransformInterface
{
    /**
     * Transform method
     * @return mixed
     */
    public function transform(): array
    {

        $date = date('Y-m-d', strtotime('+2 days')); 

        $data = [
            'auth' => [
                'authKey' => $this->data->getAuthKey(),
                'authSecret' => $this->data->getAuthSecret(),
            ],
            'data' => [
                'associatedAccountNumber' => [
                    'value' => $this->data->getAccountNumber(),
                ],
                'originDetail' => [
                    'useAccountAddress' => false,
                    'pickupLocation' => [
                        'contact' => [
                            'personName' => $this->data->getShipmentShipper()->getName(),
                            'companyName' => $this->data->getShipmentShipper()->getCompany(),
                            'phoneNumber' => $this->data->getShipmentShipper()->getPhone(),
                        ],
                        'address' => [
                            'streetLines' => [$this->data->getShipmentShipper()->getStreetLines(), $this->data->getShipmentShipper()->getStreetLines(1)],
                            'city' => $this->data->getShipmentShipper()->getCity('fedex'),
                            'stateOrProvinceCode' => $this->data->getShipmentShipper()->getStateOrProvinceCode(),
                            'postalCode' => $this->data->getShipmentShipper()->getZip(),
                            'countryCode' => $this->data->getShipmentShipper()->getCountryCode('fedex'),
                        ]
                    ],
                    'buildingPartDescription' => $this->data->getShipmentPickupInstructions(),
                    //'readyDateTimestamp' => date('Y-m-d', strtotime($this->data->getShipmentPickupDate())) . 'T' . $this->data->getShipmentPickupTimeStart() . ':00Z',
                    'readyDateTimestamp' => date('Y-m-d', strtotime('+2 days')) . 'T' . $this->data->getShipmentPickupTimeStart() . ':00Z',
                    'readyTimestamp' => $this->data->getShipmentPickupTimeStart(),
                    'companyCloseTime' => $this->data->getShipmentPickupTimeUntil() . ':00',
                    'customerCloseTime' => $this->data->getShipmentPickupTimeUntil() . ':00',
                ],
                'packageCount' => $this->getTotalCollis(),
                'totalWeight' => [
                    'units' => 'KG',
                    'value' => $this->getTotalColliWeight(),
                ],
                'expressFreightDetail' => [

                    'truckType' => 'DROP_TRAILER_AGREEMENT',
                    'service' => 'INTERNATIONAL_ECONOMY_FREIGHT',
                    'trailerLength' => 'TRAILER_28_FT',
                    'bookingNumber' => '1234AGTT',

                    'dimensions' => [
                        'length' => 20,
                        'width' => 15,
                        'height' => 12,
                        'units' => 'CM',
                    ],

                ],
                'carrierCode' => 'FDXE',
            ]
        ];

        return $data;
    }
}
