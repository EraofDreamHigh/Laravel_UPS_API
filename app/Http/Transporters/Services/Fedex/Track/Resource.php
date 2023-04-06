<?php

namespace App\Http\Transporters\Services\Fedex\Track;

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
                'includeDetailedScans' => true,
                'trackingInfo' => [
                    [
                        'trackingNumberInfo' => [
                            'trackingNumber' => $this->data->getShipmentTracking(),
                        ]
                    ]
                ]
            ]
        ];

        return $data;
    }
}
