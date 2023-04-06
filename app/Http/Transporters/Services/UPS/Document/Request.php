<?php

namespace App\Http\Transporters\Services\UPS\Document;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterSoapRequestAbstract;
use Spatie\ArrayToXml\ArrayToXml;

class Request extends TransporterSoapRequestAbstract
{
    /**
     * @var string
     */
    private $wsdl = 'PaperlessDocumentAPI.wsdl';

    /**
     * @var string
     */
    private $endPoint = 'ProcessUploading';

    /**
     * @var array
     */
    private $data;

    /**
     * Request constructor.
     * @param TransporterBaseData $data
     */
    public function __construct(TransporterBaseData $data)
    {

	    $upss['UsernameToken'] = [
		    'Username' => $data->getAuthUsername(),
		    'Password' => $data->getAuthPassword(),
	    ];
	    $upss['ServiceAccessToken'] = ['AccessLicenseNumber' => $data->getAuthKey() ];

	    parent::__construct([
		    new \SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0','UPSSecurity',$upss)
	    ]);

        $this->data = $data;

    }

    /**
     * @return string
     */
    public function getWsdl()
    {
        return app()->path() . '/Http/Transporters/Services/UPS/wsdl/' . $this->wsdl;
    }

    /**
     * @return Response
     */
    public function execute()
    {
    	$data = (new Resource($this->data))->transform();
	    $this->data = $data;
        return new Response($this->get($this->endPoint, $data), $this);
    }

	/**
	 * @param $document_id
	 * @param $shipment_id
	 * @return Response
	 */
    public function executeConnect( $document_id, $shipment_id )
    {
	    $data = (new Resource($this->data))->transformConnect($document_id, $shipment_id);
	    $this->data = $data;
        return new Response($this->get('ProcessPushToImageRepository', $data), $this);
    }


	/**
	 * @return array
	 */
	public function getRequest(){
		return $this->data;
	}

}