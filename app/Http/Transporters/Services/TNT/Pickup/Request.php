<?php

namespace App\Http\Transporters\Services\TNT\Pickup;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRestRequestAbstract;

class Request extends TransporterRestRequestAbstract
{
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
        return new Response($this->data, $this);
    }
}