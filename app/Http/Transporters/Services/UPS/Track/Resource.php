<?php

namespace App\Http\Transporters\Services\UPS\Track;

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
        	'TrackRequest' => [
	            'Request' => [
					'RequestOption' => '15',
					'TransactionReference' => [
						'CustomerContext' => '',
					],
		        ],
		        'InquiryNumber' => $this->data->getShipmentTracking(),
		        'TrackingOption' => '02',
	        ]
        ];

        return $data;
    }
}
