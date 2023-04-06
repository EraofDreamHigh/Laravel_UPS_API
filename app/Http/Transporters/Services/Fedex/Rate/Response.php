<?php

namespace App\Http\Transporters\Services\Fedex\Rate;

use App\Http\Transporters\Data\ShipmentRate;
use App\Http\Transporters\Requests\TransporterRequestInterface;
use App\Http\Transporters\Responses\TransporterResponseAbstract;
use App\Models\Log;

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

		if (isset($this->getData()['output']->rateReplyDetails[0]->customerMessages)) {
			$message = '';
			foreach ($this->getData()['output']->rateReplyDetails[0]->customerMessages as $alert) {
				$message .= '(' . $alert->code . '): ' . $alert->message . ' | ';
			}
			return $message;
		}

		if (isset($this->getData()['output']->alerts)) {
			$message = '';
			foreach ($this->getData()['output']->alerts as $alert) {
				$message .= '(' . $alert->alertType . '): ' . $alert->message . ' | ';
			}
			return $message;
		}

		if (isset(json_decode($this->data)->errors)) {
			$message = '';
			foreach (json_decode($this->data)->errors as $alert) {
				$message .= '(' . $alert->code . '): ' . $alert->message . ' | ';
			}
			return $message;
		}
		
        return $this->data ?? 'Unknown error';
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {

        if (isset($this->getData()['output']->rateReplyDetails[0])) {
            return 0;
        }

        return 500;

    }

	/**
	 * @return array
	 */
	public function getData(): array {
        if(!is_array($this->data)) {
            return (array) json_decode($this->data);
        }

        return json_decode($this->data[0]);
    }

	/**
	 * @return array
	 */
	public function getRateDetails(): array
	{

		if (isset($this->getData()['output']->rateReplyDetails)) {
			return $this->getData()['output']->rateReplyDetails;
		}

		return [];
	}

	/**
	 * @return array
	 */
	public function getRates(): array
	{

		$rates = [];

		$rateDetails = $this->getRateDetails();
		if (is_array($rateDetails)) {

			foreach ($rateDetails as $detail) {

				## Create rate object
				$rate = new ShipmentRate();
				$rate->setService($detail->serviceType);
				$rate->setPrice($detail->ratedShipmentDetails[0]->totalNetFedExCharge);
				$rate->setDeliveryAt($this->getData()['output']->quoteDate);

				$rates[] = $rate->getRate();

			}

		}

		return $rates;
	}

}
