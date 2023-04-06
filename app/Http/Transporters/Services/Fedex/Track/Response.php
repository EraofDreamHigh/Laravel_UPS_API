<?php

namespace App\Http\Transporters\Services\Fedex\Track;

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
    public $data;

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
        if(isset($this->getData()['output']['completeTrackResults'][0]['trackResults'][0]['error'])) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getData()['output']['completeTrackResults'][0]['trackResults'][0]['error']['message'] ?? 'None';
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return 200;
    }

    public function getStatus(){

		$code =  $this->getData()['output']['completeTrackResults'][0]['trackResults'][0]['latestStatusDetail']['code'] ?? '';
		$description = $this->getData()['output']['completeTrackResults'][0]['trackResults'][0]['latestStatusDetail']['description'] ?? '';

	    $error = ['CA','DD','DE','DY','HL','RS','SE','CD','PD'];
	    $picked = ['PU','PX'];
	    $delivered = ['DL'];

	    if ($description == 'Delivered'){
		    return 'delivered';
	    }

	    if (in_array($code, $delivered)) return 'delivered';
	    if (in_array($code, $picked)) return 'picked';
	    if (in_array($code, $error)) return 'error';
	    return 'none';

    }

    public function getStatusses() {
        $response = [
            'error' => false,
            'message' => '',
            'data' => [],
        ];

        if ($this->getStatus() === 'delivered') {
            $array = $response['delivered'] = $this->getData()['output']['completeTrackResults'][0]['trackResults'][0]['dateAndTimes'];
           
            $delivered = array_filter($array, function($item) {
                return $item['type'] == 'ACTUAL_DELIVERY';
            });
            array_keys($array);
            $response['delivered'] = $delivered[0]['dateTime'];

           
            $picked = array_filter($array, function($item) {
                return $item['type'] == 'ACTUAL_PICKUP';
            });
            array_keys($array);
            $response['picked'] = $picked[1]['dateTime'];
        }

        if ($this->getStatus() === 'picked') {
            $array = $response['picked'] = $this->getData()['output']['completeTrackResults'][0]['trackResults'][0]['dateAndTimes'];
            
            
            $picked = array_filter($array, function($item) {
                return $item['type'] == 'ACTUAL_PICKUP';
            });
            array_keys($array);
            $response['picked'] = $picked[1]['dateTime'];
        }

        if (!$this->isSuccess()) {
            $response['error'] = true;
            $response['message'] = $this->getMessage();
            return $response;
        }

        $response['message'] = r('De tracking informatie is bijgewerskt.');
        
        return $response;
    }

    public function getData() {
        $datajsonstring = $this->data;
        $datajson = json_decode($datajsonstring, true);
        return $datajson;
    }

}