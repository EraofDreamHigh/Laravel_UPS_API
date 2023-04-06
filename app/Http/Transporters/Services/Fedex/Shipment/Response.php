<?php

namespace App\Http\Transporters\Services\Fedex\Shipment;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
//use iio\libmergepdf\Merger as PDFMerger;
use App\Http\Transporters\Requests\TransporterRequestInterface;
use App\Http\Transporters\Responses\TransporterResponseAbstract;

class Response extends TransporterResponseAbstract
{
    /**
     * @var TransporterRequestInterface
     */
    public $request;

    /**
     * @var array|null|mixed
     */
    public $data;

    /**
     * Response constructor.
     * @param $data
     * @param TransporterRequestInterface $request
     */
    public function __construct($data, TransporterRequestInterface $request)
    {
        $this->data = $data;
        $this->request = $request;
    }

    /**
     * @return bool
     * 7030 response will happen when you are parsing multiple collis
     */
    public function isSuccess(): bool
    {
        if(!in_array($this->getStatusCode(),[0])) {
            return false;
        }
        return true;

    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        if ($this->isSuccess()) {
            return 'Success';
        }

        $code = $this->getData()['errors'][0]->code ?? '000';
        $msg = $this->getData()['errors'][0]->message ?? 'Unknown error';
        $json = $this->data;
        return '(' . $code . '): ' . $msg . ' | ' . $json;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {

        if (isset($this->getData()['output']->transactionShipments[0])) {
            return 0;
        }

        return 500;

    }

    /**
     * @return string
     */
    public function getMasterTrackingNumber()
    {

        if (isset($this->getData()['output']->transactionShipments[0]->masterTrackingNumber)) {
            return $this->getData()['output']->transactionShipments[0]->masterTrackingNumber;   
        }

        return '';

    }

    /**
     * @return string
     */
    public function getShipmentTracking()
    {

        if (isset($this->getData()['output']->transactionShipments[0]->completedShipmentDetail->completedPackageDetails[0]->trackingIds[0]->trackingNumber)) {
            return $this->getData()['output']->transactionShipments[0]->completedShipmentDetail->completedPackageDetails[0]->trackingIds[0]->trackingNumber;
        }

        return '';

    }

    /**
     * @param string $fileName
     * @return string $file
     */
    public function storeLabel(string $fileName)
    {

        if ($this->isSuccess()) {

            if (count($this->request->getTransporterBaseData()->getLabels()) > 1) {

                /*
                $merger = new PDFMerger;

                foreach ( $this->request->getTransporterBaseData()->getLabels() as $key => $label ) {

                    $file = $fileName . '-' . ( $key + 1 ) . '.' . mb_strtolower( $label['extension'] );

                    Storage::disk( 'private' )->put(
                        'fedex/' . $file,
                        $label['data']
                    );

                    $merger->addFile(storage_path('app/private/fedex/' . $file));
                }
                

                Storage::disk('private')->put('fedex/' . $fileName . '.pdf',  $merger->merge());
                */

            } else {

                foreach ( $this->request->getTransporterBaseData()->getLabels() as $key => $label ) {

                    /*
                    Storage::disk( 'private' )->put(
                        'fedex/' . $fileName . '.pdf',
                        $label['data']
                    );
                    */

                    break;
                }

            }

        }

        return $fileName . '.pdf';

    }

    /**
     */
    public function getData() {
        if(!is_array($this->data)) {
            return (array) json_decode($this->data);
        }

        return (array) json_decode($this->data[0]);
    }

}
