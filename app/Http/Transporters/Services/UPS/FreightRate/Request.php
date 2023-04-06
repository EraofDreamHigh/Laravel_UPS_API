<?php

namespace App\Http\Transporters\Services\UPS\FreightRate;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterSoapRequestAbstract;

class Request extends TransporterSoapRequestAbstract
{
    /**
     * @var string
     */
    private $wsdl = 'FreightRate.wsdl';

    /**
     * @var string
     */
    private $endPoint = 'ProcessFreightRate';

    /**
     * @var array
     */
    private $data;

    /**
     * Request constructor.
     * @param $data
     */
    public function __construct(TransporterBaseData $data) {
	    $upss['UsernameToken'] = [
	    	'Username' => $data->getAuthUsername(),
	    	'Password' => $data->getAuthPassword(),
	    ];
	    $upss['ServiceAccessToken'] = ['AccessLicenseNumber' => $data->getAuthKey() ];

	    parent::__construct([
		    new \SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0','UPSSecurity',$upss)
	    ]);

        $this->data = (new Resource($data))->transform();
    }

    /**
     * @return string
     */
    public function getWsdl() {
        return app()->path() . '/Http/Transporters/Services/UPS/wsdl/' . $this->wsdl;
    }

    /**
     * @return Response
     */
    public function execute() {
        $res = $this->post($this->endPoint, $this->data);
        try {
            return new Response($res, $this);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), $this);
        }
    }

    /**
     * @return array
     */
    public function getRequest(){
        return $this->data;
    }
}
