<?php

namespace App\Http\Transporters\Services\TNT\Rate;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRestRequestAbstract;
use Illuminate\Support\Facades\Log;
use function MongoDB\BSON\toJSON;

class Request extends TransporterRestRequestAbstract
{
	/**
	 * @var string
	 */
	private $endPoint = 'https://express.tnt.com/expressconnect/pricing/getprice';

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
		parent::__construct([
			'auth' => [
				$data->getAuthKey(),
				$data->getAuthSecret()
			],
			'verify' => false,
	    ]);

        $this->data = (new Resource($data))->transform();
    }

	/**
	 * @return Response
	 */
	public function execute()
	{
		Log::error(json_encode($this->data));
		return new Response($this->post($this->endPoint, $this->data), $this);
	}

	/**
	 * @return array
	 */
	public function getRequest()
	{
		return $this->data;
	}

}
