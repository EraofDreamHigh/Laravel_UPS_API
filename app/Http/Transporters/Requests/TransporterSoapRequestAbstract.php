<?php

namespace App\Http\Transporters\Requests;

use Illuminate\Support\Facades\Log;
use SoapClient;

abstract class TransporterSoapRequestAbstract extends TransporterRequestAbstract
{
    /**
     * @var SoapClient
     */
    protected $client;

    /**
     * @var array
     */
    private $options = [
        'trace' => true,
        'exceptions' => true,
        'cache_wsdl' => WSDL_CACHE_BOTH,
        'connection_timeout' => 3
    ];

    /**
     * TransporterSoapRequestAbstract constructor.
     * @param array $headers
     */
    public function __construct($headers = []) {
        parent::__construct();

        $this->client = new SoapClient($this->getWsdl(), $this->options);

        if(!empty($headers)) {
            $this->client->__setSoapHeaders($headers);
        }
    }

	/**
	 * @param string $endPoint
	 * @param array $payload
	 * @return mixed
	 */
    public function get(string $endPoint, array $payload)
    {
	    $call = null;
    	try {

		    if(!empty($headers)) {
			    $this->client->__setSoapHeaders($headers);
		    }

		    $call = $this->client->__soapCall($endPoint, $payload);

	    } catch ( \Exception $e){

		    Log::debug('' . $endPoint . '-headers = ' . $this->client->__getLastRequestHeaders ());
		    Log::debug('' . $endPoint . '-request = ' . $this->client->__getLastRequest());
		    Log::debug('' . $endPoint . '-response = ' . $this->client->__getLastResponse());

		    $call = $this->client->__getLastResponse();

	    }

	    Log::debug('' . $endPoint . '-headers = ' . $this->client->__getLastRequestHeaders ());
	    Log::debug('' . $endPoint . '-request = ' . $this->client->__getLastRequest());
	    Log::debug('' . $endPoint . '-response = ' . $this->client->__getLastResponse());

	    return $call;
    }

    /**
     * @param string $endPoint
     * @param array $payload
     * @return mixed
     */
    public function post(string $endPoint, array $payload)
    {
        return $this->client->__soapCall($endPoint, $payload);
    }

    /**
     * @return SoapClient
     */
    public function getClient()
    {
        return $this->client;
    }

    abstract public function getWsdl();

    abstract public function execute();
}
