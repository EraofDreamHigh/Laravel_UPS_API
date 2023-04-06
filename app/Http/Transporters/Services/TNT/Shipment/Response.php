<?php

namespace App\Http\Transporters\Services\TNT\Shipment;

use Illuminate\Support\Facades\Storage;
use iio\libmergepdf\Merger as PDFMerger;
use App\Http\Transporters\Requests\TransporterRequestInterface;
use App\Http\Transporters\Responses\TransporterResponseAbstract;

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

    protected $dataRaw;

    /**
     * Response constructor.
     * @param $data
     * @param TransporterRequestInterface $request
     */
    public function __construct($data, TransporterRequestInterface $request)
    {
        $this->dataRaw = $data;
        $this->data = $this->xmlToObject($data);
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        if(isset($this->data->ERROR) || isset($this->data->error_reason)) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        if (isset($this->data->error_reason)){
            return $this->data->error_reason;
        }

        if(isset($this->data->ERROR) && is_array($this->data->ERROR)) {
            return $this->data->ERROR[0]->DESCRIPTION;
        }

        return $this->data->ERROR->DESCRIPTION;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        if(is_array($this->data->ERROR)) {
            return $this->data->ERROR[0]->CODE;
        }

        return (int) $this->data->ERROR->CODE;
    }

    /**
     * @return string
     */
    public function getShipmentTracking()
    {
        return $this->data->CREATE->CONNUMBER;
    }

    /**
     * @return string
     */
    public function getPickupCode()
    {
        return (isset($this->data->BOOK->CONSIGNMENT->BOOKINGREF)) ? $this->data->BOOK->CONSIGNMENT->BOOKINGREF : '';
    }

    /**
     * @return array|mixed|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array|mixed|null
     */
    public function getDataRaw()
    {
        return $this->dataRaw;
    }

    /**
     * @param string $fileName
     */
    public function storeLabel(string $fileName, $other = null, $labeltype = 'label') {

	    $files = [];

		if ($this->getLabelType($labeltype) == 'old') {
			$files['label'] = $this->request->storeLabel($fileName . '-label');
		} else if ($this->getLabelType($labeltype) == 'A4') {
			$files['label'] = storage_path('app/private/tnt/' . $other);
		}

	    $files['manifest'] = $this->request->storeManifest($fileName . '-manifest');
	    $files['consignment_note'] = $this->request->storeConsignmentNote($fileName . '-consignment-note');

	    $merger = new PDFMerger;

	    foreach ($files as $type => $filePath) {
	    	if (file_exists($filePath)) {
			    $merger->addFile($filePath);
		    }
	    }

	    Storage::disk('public')->put('tnt/' . $fileName . '.pdf', $merger->merge());

	    return $fileName . '.pdf';
    }

	public function getLabelType($labeltype){
		if ($labeltype !== ''){
			return $labeltype;
		}
		return 'label';

	}

}
