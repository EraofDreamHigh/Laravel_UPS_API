<?php

namespace App\Http\Transporters\Services\TNT\Label;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRestRequestAbstract;
use Illuminate\Support\Facades\Storage;
use Spatie\ArrayToXml\ArrayToXml;

class Request extends TransporterRestRequestAbstract
{
    /**
     * @var string
     */
    #private $endPoint = 'https://express5.tnt.com/expresslabel/documentation/getlabel';
    private $endPoint = 'https://express.tnt.com/expresslabel/documentation/getlabel';

    /**
     * @var array
     */
    private $data;
    public $base;

    /**
     * Request constructor.
     * @param TransporterBaseData $data
     */
    public function __construct(TransporterBaseData $data)
    {
        parent::__construct();

        $this->base = $data;
        $this->data = (new Resource($data))->transform();

    }

	public function execute()
	{

		$xml = ArrayToXml::convert($this->data,'labelRequest');

//		Storage::put('testing/test.xml', $xml);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->endPoint);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERPWD, $this->base->getAuthSecret() . ":" . $this->base->getAuthKey());
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		$result = curl_exec($ch);

		Storage::put('testing/response.xml', $result);

		return new Response( $result , $this);
	}


}