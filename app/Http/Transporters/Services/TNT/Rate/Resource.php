<?php

namespace App\Http\Transporters\Services\TNT\Rate;

use Spatie\ArrayToXml\ArrayToXml;

use App\Http\Transporters\Services\TNT\TNTBaseResource;

class Resource extends TNTBaseResource
{
    /**
     * @return array
     */
    public function transform(): array {

        $body = [
            'appId' => 'PC',
            'appVersion' => '3.1',
            'priceCheck' => [
                'rateId' => 'Rate2',
                'sender' => [
                    'country' => $this->data->getShipmentShipper()->getCountryCode('tnt'),
                    'town' => $this->data->getShipmentShipper()->getCity('tnt'),
                    'postcode' => $this->data->getShipmentShipper()->getZip('tnt'),
                ],
                'delivery' => [
                    'country' => $this->data->getShipmentRecipient()->getCountryCode('tnt'),
                    'town' => $this->data->getShipmentRecipient()->getCity('tnt'),
                    'postcode' => $this->data->getShipmentRecipient()->getZip('tnt'),
                ],
                'collectionDateTime' => date('Y-m-d', strtotime($this->data->getShipmentDate())) . 'T12:00:00',
                'product' => [
                    'type' => 'N',
                ],
                'account' => [
                    'accountNumber' => $this->data->getAccountNumber(),
                    'accountCountry' => 'NL',
                ]
            ]
        ];

        if($this->data->getShipmentInsuranceValue() > 0 ) {
            $body['priceCheck']['insurance'] = [
                'insuranceValue' => $this->data->getShipmentInsuranceValue(),
                'goodsValue' => $this->data->getShipmentInsuranceValue(),
            ];
        }

        $body['priceCheck']['currency'] = $this->data->getShipmentCurrency();
        $body['priceCheck']['priceBreakDown'] = true;
        $body['priceCheck']['consignmentDetails'] = [
            'totalWeight' => $this->getTotalColliWeight(),
            'totalVolume' => $this->getTotalColliVolume(),
            'totalNumberOfPieces' => $this->getTotalCollies(),
        ];

        $data = [
            'headers' => [
                'Content-Type' => 'application/xml',
            ],
            'timeout' => 5,
            'body' => ArrayToXml::convert($body, 'priceRequest')
        ];

        return $data;
    }
}
