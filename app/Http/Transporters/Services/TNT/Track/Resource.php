<?php

namespace App\Http\Transporters\Services\TNT\Track;

use Spatie\ArrayToXml\ArrayToXml;
use App\Http\Transporters\Services\TNT\TNTBaseResource;

class Resource extends TNTBaseResource
{
    /**
     * @return array
     * https://express.tnt.com/expresswebservices-website/docs/ExpressConnect_Tracking_V3_1.pdf
     */
    public function transform(): array {
        $body = [
            'SearchCriteria' => [
                'ConsignmentNumber' => $this->data->getShipmentTracking(),
                'Account' => [
                    'Number' => $this->data->getAccountNumber(),
                    'CountryCode' => 'NL',
                ],
            ],
            'LevelOfDetail' => [
                'Complete' => [
                    '_attributes' => [
                        'originAddress' => 'true',
                        'destinationAddress' => 'true',
                        'package' => 'true',
                        'shipment' => 'true',
                    ]
                ],
            ]
        ];

        $data = [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('TBBLIVE123:TBBLIVE123'),
            ],
            'timeout' => 5,
            'form_params' => [
                'xml_in' => ArrayToXml::convert($body, 'trackRequest')
            ]
        ];

        return $data;
    }
}
