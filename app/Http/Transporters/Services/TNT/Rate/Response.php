<?php

namespace App\Http\Transporters\Services\TNT\Rate;

use App\Http\Transporters\Data\ShipmentRate;
use App\Http\Transporters\Requests\TransporterRequestInterface;
use App\Http\Transporters\Responses\TransporterResponseAbstract;
use Illuminate\Support\Facades\Log;

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

	protected $excludeServices = [
		'IDE Economy',
		'IDE Express',
		'IDE Mastercon Air',
		'IDE Mastercon Road',
	];

	protected $excludeServiceIds = [
		'48F'
	];

	/**
	 * Response constructor.
	 * @param $data
	 * @param TransporterRequestInterface $request
	 */
	public function __construct($data, TransporterRequestInterface $request)
	{
		$this->data = $this->xmlToObject($data);
		$this->request = $request;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool {
        if(
            !isset($this->data->priceResponse)
            || !isset($this->data->priceResponse->ratedServices)
            || !isset($this->data->priceResponse->ratedServices->ratedService)
        ) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getMessage(): string {

        if(isset($this->data->errors->brokenRule)) {

            if (is_array($this->data->errors->brokenRule)){
                $errors = '';

                foreach( $this->data->errors->brokenRule as $rule ){
                    $errors .= $rule->code . ' - ' . $rule->description . '<br />';
                }

                return $errors;
            }

            return $this->data->errors->brokenRule->description;
        }

        return $this->data->errors->parseError->errorReason;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int {
        if(isset($this->data->errors->brokenRule)) {
            return (int) $this->data->errors->code;
        }

        return (int) $this->data->parseError->errorLine;
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

    /**
     * @return array
     */
    public function getRateDetails(): array {

        if (isset($this->data->priceResponse->ratedServices->ratedService)){

            if ( ! is_array( $this->data->priceResponse->ratedServices->ratedService ) ) {

                $rates[] = $this->data->priceResponse->ratedServices->ratedService;

            } else {

                $rates = $this->data->priceResponse->ratedServices->ratedService;

            }

            return $rates;
        }

        return [];
    }

    /**
     * @return array
     */
    public function getRates(): array {

        $rates = [];

        $rateDetails = $this->getRateDetails();
        if (is_array($rateDetails)){

            foreach( $rateDetails as $detail ){

	            if (isset($detail->product->productDesc)) {

		            if (in_array($detail->product->productDesc, $this->excludeServices)) {

			            Log::error("TNT - Excluded the service: " . $detail->product->productDesc);
			            continue;

		            }

	            }

	            if (isset($detail->product->id)) {

		            if (in_array($detail->product->id, $this->excludeServiceIds)) {

			            Log::error("TNT - Excluded the service: " . $detail->product->id);
			            continue;

		            }

	            }

	            ## Create rate object
	            $rate = new ShipmentRate();
	            $rate->setService($detail->product->id);
	            $rate->setPrice($detail->totalPriceExclVat);
	            $rate->setDeliveryAt($detail->estimatedTimeOfArrival);

	            $rates[] = $rate->getRate();

            }

        }

        return $rates;
    }

}
