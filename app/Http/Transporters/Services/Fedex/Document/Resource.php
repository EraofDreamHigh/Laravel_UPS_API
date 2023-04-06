<?php

namespace App\Http\Transporters\Services\Fedex\Document;

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
        $futureDate = new \DateTime();
	    $futureDate->modify("+7 day");

        $data = [
            'auth' => [
                'authKey' => $this->data->getAuthKey(),
                'authSecret' => $this->data->getAuthSecret(),
            ],
            'data' => [
                'attachment' => $this->data->getInvoiceBase64File(),
                'document' => [
                    'workflowName' => 'ETDPreshipment',
                    'carrierCode' => 'FDXE',
                    'name' => $this->data->getInvoiceFileName(),
                    'contentType' => "application/pdf",
                    'meta' => [
                        'shipDocumentType' => 'COMMERCIAL_INVOICE',
                        'originCountryCode' => $this->data->getInvoiceOriginCountryCode(),
                        'destinationCountryCode' => $this->data->getInvoiceDestinationCountryCode()
                    ]
                ],
            ]
        ];


        return $data;
    }
}
