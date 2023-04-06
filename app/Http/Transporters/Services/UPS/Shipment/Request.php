<?php

namespace App\Http\Transporters\Services\UPS\Shipment;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRequestAbstract;
use Ups\Shipping;

class Request extends TransporterRequestAbstract
{

    /**
     * @var array
     */
    private $data;
    private $shipment;

    /**
     * Request constructor.
     * @param $data
     */
    public function __construct(TransporterBaseData $data) {
        parent::__construct();

        $this->data = $data;
        $this->shipment = (new Resource($data))->prepair();
    }

    public function get($endPoint, $payload)
    {
        exec('rm -f ' . storage_path('logs/ups-rates2023.log'));

	    // Create logger
	    $log = new \Monolog\Logger('ups');
	    $log->pushHandler(new \Monolog\Handler\StreamHandler(storage_path('logs/ups-shipment2023.log'), \Monolog\Logger::DEBUG));

	    $shipping = new Shipping(
	    	$this->data->getAuthKey(),
	    	$this->data->getAuthUsername(),
	    	$this->data->getAuthPassword(),
		    false,
		    null,
		    $log
	    );

	    $confirm = $shipping->confirm(
	    	Shipping::REQ_VALIDATE,
		    $this->shipment
	    );

	    if ($confirm) {
		    return $shipping->accept($confirm->ShipmentDigest);
	    }

    }

    public function post(string $endPoint, array $payload)
    {
    }

	/**
     * @return Response
     */
    public function execute() {
        return new Response($this->get('', $this->data), $this);
    }

    /**
     * @return array
     */
    public function getRequest(){
        return $this->data;
    }

}
