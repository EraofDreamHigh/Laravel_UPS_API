<?php

namespace App\Http\Transporters\Services\Fedex\Pickup;

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
    protected $data;

    /**
     * Response constructor.
     * @param $data
     * @param TransporterRequestInterface $request
     */
    public function __construct(array $data, TransporterRequestInterface $request) {
        $this->data = $data;
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool {
        if(!in_array($this->getStatusCode(), [500])) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        if ($this->isSuccess()) {
            return 'Pickup Request Executed Successfully. Pickup confirmation code: '. json_decode($this->data)['output']->pickupConfirmationCode . '. Location: ' . json_decode($this->data)['output']->location;
        } else {
            return 'Pickup Request Failed. Error: ' . json_decode($this->data)['errors'][0]->message;
        }
    }

    /**
     * @return int
     */
    public function getStatusCode(): int {
        if (isset($this->data['errors'])) {
            return 500;
        }
        return 100;
    }

    public function getPickupCode(){
        return json_decode($this->data)['output']->pickupConfirmationCode;
    }

    /**
     * @return array
     */
    public function getData(): array {
        if(!is_array($this->data)) {
            return (array) $this->data;
        }

        return (array) $this->data;
    }

}
