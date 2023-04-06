<?php

namespace App\Http\Transporters\Services\Fedex\Document;

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
        if(!in_array($this->getStatusCode(), [0])) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        if(is_array($this->data->output->Alert)) {
            return $this->data->output->Alerts[0]->Message;
        }

        return $this->data->output->Alerts->Message;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int {
        if(is_array($this->data->output->Alert)) {
            return $this->data->output->Alert[0]->Code;
        }

        return $this->data->output->Alert->Code;
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

}

