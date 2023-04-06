<?php

namespace App\Http\Transporters\Services\TNT\Track;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRestRequestAbstract;

class Request extends TransporterRestRequestAbstract
{
    /**
     * @var string
     */
    private $endPoint = 'https://express.tnt.com/expressconnect/track.do';

    /**
     * @var array
     */
    private $data;

    /**
     * Request constructor.
     * @param TransporterBaseData $data
     */
    public function __construct(TransporterBaseData $data)
    {
        parent::__construct();

        $this->data = (new Resource($data))->transform();
    }

    /**
     * @return Response
     */
    public function execute()
    {
        return new Response($this->post($this->endPoint, $this->data), $this);
    }
}