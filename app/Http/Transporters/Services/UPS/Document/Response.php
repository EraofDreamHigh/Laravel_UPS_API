<?php

namespace App\Http\Transporters\Services\UPS\Document;

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
		if(isset($this->data->PRN)) {
			return true;
		}

		return false;
	}


	public function getStatusCode(){
		return 0;
	}

	/**
	 * @return string
	 */
	public function getMessage(): string {
		return $this->data->faultstring;
	}

	public function getDocumentID(){
		return $this->data->FormsHistoryDocumentID->DocumentID ?? false;
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
