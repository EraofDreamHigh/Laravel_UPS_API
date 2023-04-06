<?php

namespace App\Http\Transporters\Services\UPS\Rate;

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
        if(isset($this->data->RatedShipment)) {
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

        if (isset($this->data->RatedShipment)){

            if ( ! is_array( $this->data->RatedShipment ) ) {
                $rates[] = $this->data->RatedShipment;
            } else {
                $rates = $this->data->RatedShipment;
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

        $details = $this->getRateDetails();
        Log::error(json_encode($details));
        if (is_array($details)){

            foreach( $details as $detail ){

                ## Check for timestamp, if not, not a valid rate
                if ( !isset( $detail->Service ) ) {
                    continue;
                }

                ## Build service
                $service = $detail->Service->getCode();
                $name = $detail->Service->getName();
                if ($name != ''){
                	$service .= '-' . $name;
                }

                ## Get delivery
	            $delivery = $detail->TimeInTransit->ServiceSummary->getEstimatedArrival();

                ## Check if date is weekend
	            $weekday = date('N', strtotime($delivery->getArrival()->getDate()));
	            if (in_array($weekday,[6,7])){
	            	continue;
	            }


                ## Create rate object
                $rate = new ShipmentRate();
                $rate->setService( $service );
                $rate->setPrice( $detail->NegotiatedRates->NetSummaryCharges->GrandTotal->MonetaryValue );
                $rate->setDeliveryAt( $delivery->getArrival()->getDate() . ' ' . $delivery->getArrival()->getTime() );

                $rates[] = $rate->getRate();

            }

        }

        return $rates;
    }

}
