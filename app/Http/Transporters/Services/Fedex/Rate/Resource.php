<?php

namespace App\Http\Transporters\Services\Fedex\Rate;

use App\Http\Transporters\Services\Fedex\FedexBaseResource;
use App\Http\Transporters\Rules\TransporterMustTransformInterface;

class Resource extends FedexBaseResource implements TransporterMustTransformInterface
{
    /**
     * @return array
     */
    public function transform(): array
    {
        $data = [
            'auth' => [
                'authKey' => $this->data->getAuthKey(),
                'authSecret' => $this->data->getAuthSecret(),
            ],
            
            'data' => [
                'accountNumber' => [
                    'value' => $this->data->getAccountNumber(),
                ],
                'requestedShipment' => [
                    'shipper' => [
                        'address' => [
                            'city' => $this->data->getShipmentShipper()->getCity('fedex'),
                            'countryCode' => $this->data->getShipmentShipper()->getCountryCode('fedex'),
                            'postalCode' => $this->data->getShipmentShipper()->getZip('fedex'),
                        ],
                    ],

                    'recipient' => [
                        'address' => [
                            'city' => $this->data->getShipmentRecipient()->getCity('fedex'),
                            'countryCode' => $this->data->getShipmentRecipient()->getCountryCode('fedex'),
                            'postalCode' => $this->data->getShipmentRecipient()->getZip('fedex'),
                        ]
                    ],

                    "pickupType" => "USE_SCHEDULED_PICKUP",

                    //'serviceType' => $this->getService(),

                    //'packagingType' => $this->getShipmentType(),

                    "rateRequestType" => ['LIST', 'ACCOUNT'],

                    'requestedPackageLineItems' => $this->getColliLines(),
                ],
            ]
        ];

        return $data;
    }
}
