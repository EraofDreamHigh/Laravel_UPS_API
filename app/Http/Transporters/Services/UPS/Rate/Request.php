<?php

namespace App\Http\Transporters\Services\UPS\Rate;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRequestAbstract;
use App\Http\Transporters\Services\UPS\Custom\RateTimeInTransit;

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
	    $log->pushHandler(new \Monolog\Handler\StreamHandler(storage_path('logs/ups-rates2023.log'), \Monolog\Logger::DEBUG));

	    $rate = new RateTimeInTransit(
	    	$this->data->getAuthKey(),
	    	$this->data->getAuthUsername(),
	    	$this->data->getAuthPassword(),
		    false,
		    $log
	    );

	    $result = $rate->shopRatesTimeInTransit( $this->shipment );

	    $this->shipment = $rate->getRequest();

	    return $result;

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
        return $this->toArray($this->shipment);
    }

	private function toArray($object) {
		$reflectionClass = new \ReflectionClass(get_class($object));
		$array = array();
		foreach ($reflectionClass->getProperties() as $property) {
			$property->setAccessible(true);
			$array[$property->getName()] = $property->getValue($object);
			$property->setAccessible(false);
		}
		return $array;
	}

}

