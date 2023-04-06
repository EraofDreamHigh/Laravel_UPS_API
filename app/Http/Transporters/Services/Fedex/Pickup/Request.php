<?php

namespace App\Http\Transporters\Services\Fedex\Pickup;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRestRequestAbstract;
use App\Http\Transporters\Services\Fedex\Traits\getTokenTrait;

class Request extends TransporterRestRequestAbstract
{
    use getTokenTrait;

    /**
     * @var string
     */
    private $endPoint = 'https://apis-sandbox.fedex.com//pickup/v1/pickups';

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
        try {
            $res = $this->post($this->endPoint, $this->data['data'], $headers = [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]);
            $response = new Response((array) json_decode($res), $this);
        } catch (\Exception $e) {
           return $e->getMessage();
        }

       return $response;
    }

    /**
     * @return array
     */
    public function getRequest()
    {
        return $this->data;
    }

}
