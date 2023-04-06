<?php

namespace App\Http\Transporters\Services\UPS\Shipment;

use App\Http\Transporters\Requests\TransporterRequestInterface;
use App\Http\Transporters\Responses\TransporterResponseAbstract;
use ErrorException;
use Illuminate\Support\Facades\Storage;

class Response extends TransporterResponseAbstract
{
    /**
     * @var TransporterRequestInterface
     */
    public $request;

    /**
     * @var array|null
     */
    protected $data;

    /**
     * Response constructor.
     * @param $data
     * @param TransporterRequestInterface $request
     */
    public function __construct($data, TransporterRequestInterface $request) {
        $this->data = $data;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool {
        if(isset($this->data->PackageResults)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        if(is_array($this->data->Notifications)) {
            return $this->getStatusCode() . ' - ' . $this->data->Notifications[0]->Message;
        }

        return $this->data->Notifications->Message;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int {
        return 0;
    }


	/**
	 * @return string
	 */
	public function getShipmentTracking()
	{
		return $this->data->ShipmentIdentificationNumber;

	}

    /**
	 * @return array
	 */
	public function getShipmentTrackings()
	{
        $tracking = [];

        $packages = $this->data->PackageResults;
        
        if (is_array($packages)) {
        
            foreach ($packages as $package) {
                if (isset($package->TrackingNumber)) {
                    $tracking[] = $package->TrackingNumber;
                }
            }
            
        } else {
            $tracking[] = $packages->TrackingNumber;
        }
		return $tracking;
	}

	/**
	 * @return string
	 */
	public function getPickupCode()
	{
		return '';
	}

	/**
	 * @param string $file
	 */
	public function storeLabel(string $fileName)
	{

		$packages = $this->data->PackageResults;
		if (!is_array($packages)){
			$packages = [$packages];
		}

		$files = [];
		foreach( $packages as $nr => $package ) {

			$file = $fileName . '-' . $nr . '.' . mb_strtolower($package->LabelImage->LabelImageFormat->Code);

			Storage::disk('private')->put(
				'ups/' . $file,
				base64_decode($package->LabelImage->GraphicImage)
			);

			$files[] = $file;

		}

		$images = [];
		foreach( $files as $file ){
			$images[] = Storage::disk('private')->path('ups/' . $file);
		}

		$file = $fileName . '.pdf';
		$label = $this->request->getRequest()->getLabelTemplate();

		$pdf = app()->make('dompdf.wrapper');
		$pdf->loadView('dash::pdf.shipments.ups-labels', compact('images','label'))->save( Storage::disk('private')->path('ups/' . $file) );

		return $file;

	}


	/**
     * @return array
     */
    public function getData(): array {
        if(!is_array($this->data)) {
            return (array) $this->data;
        }

        return $this->data;
    }

}
