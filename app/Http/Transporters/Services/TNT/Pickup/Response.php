<?php

namespace App\Http\Transporters\Services\TNT\Pickup;

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

        $this->data = is_array($data) ? $data : $this->xmlToObject($data);
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return '';
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return 200;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
