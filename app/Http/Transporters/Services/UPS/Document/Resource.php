<?php

namespace App\Http\Transporters\Services\UPS\Document;

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
			'UploadRequest' => [
				'Request' => [
					'RequestOption' => 1
				],
				'ShipperNumber' => $this->data->getAccountNumber(),
				'UserCreatedForm' => [
					'UserCreatedFormFileName' => $this->data->getInvoiceFileName(),
					'UserCreatedFormFile' => $this->data->getInvoiceBase64File(),
					'UserCreatedFormFileFormat' => 'pdf',
					'UserCreatedFormDocumentType' => '002',
				],
			]
		];

		return $data;

	}

	/**
	 * @param $document_id
	 * @param $shipment_id
	 * @return array[]
	 */
	public function transformConnect( $document_id, $shipment_id ): array
	{

		$date = \DateTime::createFromFormat("Y-m-d H:i:s", $this->data->getShipmentDate());
		$data = [
			'PushToImageRepositoryRequest' => [
				'Request' => [
					'RequestOption' => 1
				],
				'ShipperNumber' => $this->data->getAccountNumber(),
				'FormsHistoryDocumentID' => [
					'DocumentID' => $document_id,
				],
				'ShipmentDateAndTime' => $date->format('Y-m-d-H.i.s'),
				'ShipmentIdentifier' => $shipment_id,
				'ShipmentType' => '1',
				'TrackingNumber' => $shipment_id,
			]
		];

		return $data;

	}

}
