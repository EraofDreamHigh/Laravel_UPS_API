<?php

namespace App\Http\Transporters\Services\UPS\FreightRate;

use App\Http\Transporters\Requests\TransporterRequestInterface;
use App\Http\Transporters\Responses\TransporterResponseAbstract;

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
        return true;
    }

    public function getStatusCode(): int
    {
        return 200;
    }


    /**
     * @return string
     */
    public function getMessage(): string {
        return '';
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
    public function getRequest(): array {
        if(!is_array($this->request)) {
            return (array) $this->request;
        }

        return $this->request;
    }

}
