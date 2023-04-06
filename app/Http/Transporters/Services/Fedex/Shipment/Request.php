<?php

namespace App\Http\Transporters\Services\Fedex\Shipment;

use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRestRequestAbstract;
use App\Http\Transporters\Services\Fedex\Traits\getTokenTrait;

class Request extends TransporterRestRequestAbstract
{
    use getTokenTrait;

    /**
     * @var string
     */
    private $endPoint = 'https://apis-sandbox.fedex.com/ship/v1/shipments';

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $transporterBaseData;

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

        $this->transporterBaseData = $data;
        $this->data = (new Resource($data))->transform();
        $this->token = $this->getToken($this->data['auth']['authKey'], $this->data['auth']['authSecret']);
    }

    /**
     * @return Response
     */
    public function execute()
    {
        try {
            $response =  new Response($this->post($this->endPoint, $this->data['data'], $headers = [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]), $this);
        }   catch (\Exception $exception) {
            if ($exception->getCode() == 504) {
                return new Response('Gateway Timeout', $this);
            }
            return new Response($exception->getResponse()->getBody()->getContents(), $this);
        }
        
        if (isset($response->getData()['output']->transactionShipments[0]->shipmentDocuments[0])) {
            $documents = $response->getData()['output']->transactionShipments[0]->shipmentDocuments;
            foreach ($documents as $document) {
                $pdf_url = $document->url;
                $pdf_data = file_get_contents($pdf_url);
                if (isset($document->contentType) && $document->contentType == 'MERGED_LABEL_DOCUMENTS') {
                    $this->transporterBaseData->addLabel([
                        'extension' => $document->docType,
                        'data' => $pdf_data
                    ]);
                }
            }  
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

    /**
     * @return array
     */
    public function getTransporterBaseData()
    {
        return $this->transporterBaseData;
    }
}
