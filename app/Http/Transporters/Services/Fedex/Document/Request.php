<?php

namespace App\Http\Transporters\Services\Fedex\Document;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRestRequestAbstract;
use App\Http\Transporters\Services\Fedex\Traits\getTokenTrait;

class Request extends TransporterRestRequestAbstract
{

    use getTokenTrait;

    /**
     * @var string
     */
    private $endPoint = 'https://documentapitest.prod.fedex.com/sandbox/documents/v1/etds/upload';

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $token;

    /**
     * Request constructor.
     * @param TransporterBaseData $data
     */
    public function __construct(TransporterBaseData $data)
    {
        parent::__construct();

        $this->data = (new Resource($data))->transform();
        $this->token = $this->getToken($this->data['auth']['authKey'], $this->data['auth']['authSecret']);
    }

    /**
     * @return Response
     */
    public function execute()
    {
        //tst($this->data['data']);
        return new Response($this->post($this->endPoint, $this->data['data'], $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => "multipart/form-data",
            'Accept' => 'application/json',
        ]), $this);
    }
}
