<?php

namespace App\Http\Transporters\Services\TNT\Shipment;

use DOMDocument;
use XSLTProcessor;
use Spatie\ArrayToXml\ArrayToXml;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Http\Transporters\Data\TransporterBaseData;
use App\Http\Transporters\Requests\TransporterRestRequestAbstract;

class Request extends TransporterRestRequestAbstract
{
    /**
     * @var int
     */
    private $callId;

    /**
     * @var string
     */
    private $tracking;

    /**
     * @var string
     */
    private $endPoint = 'https://express.tnt.com/expressconnect/shipping/ship';

    /**
     * @var array
     */
    private $data;

    /**
     * @var TransporterBaseData
     */
    private $transporterBaseData;

    /**
     * Request constructor.
     * @param TransporterBaseData $data
     */
    public function __construct(TransporterBaseData $data) {
        parent::__construct();

        $this->data = (new Resource($data))->transform();
        $this->transporterBaseData = $data;
    }

    /**
     * @param int $callId
     */
    public function setCallId(int $callId) {
        $this->callId = $callId;
    }

    /**
     * @return int
     */
    public function getCallId() {
        return $this->callId;
    }

    /**
     * @param string
     */
    public function setTracking(string $tracking) {
        $this->tracking = $tracking;
    }

    /**
     * @return string
     */
    public function getTracking() {
        return $this->tracking;
    }

    /**
     * @return Response
     */
    public function execute() {
        $callId = (int) str_replace('COMPLETE:', '', $this->postUri($this->endPoint, $this->data));

        $this->setCallId($callId);

        $results = new Response(
            $this->postUri($this->endPoint, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => [
                    'xml_in' => 'GET_RESULT:' . $callId,
                ]
            ]), $this);

        $this->setTracking((isset($results->getData()->CREATE->CONNUMBER) ? $results->getData()->CREATE->CONNUMBER : 'unknown'));

        return $results;
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function storeLabel(string $fileName)
    {
        return $this->storePdf('GET_LABEL', $fileName);
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function storeConsignmentNote(string $fileName)
    {
        return $this->storePdf('GET_CONNOTE', $fileName);
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function storeManifest(string $fileName)
    {
        return $this->storePdf('GET_MANIFEST', $fileName);
    }

    private function storePdf(string $type, string $fileName)
    {
//        $xslLocation = 'https://express.tnt.com/expresswebservices-website/stylesheets/HTMLAddressLabelRenderer.xsl';
//
//        if($type === 'GET_MANIFEST') {
//            $xslLocation = app()->path() . '/Http//Transporters/Services/TNT/TNTRenderer.xsl';
//        }

        $label = new Response(
            $this->postUri($this->endPoint, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => [
                    'xml_in' => $type . ':' . $this->getCallId(),
                ]
            ]), $this);

        #$objectToArray = json_decode(json_encode($label->getData()), true);

        /**
         * $labelXml = str_replace('<?xml version="1.0"?>', '', ArrayToXml::convert($objectToArray, 'CONSIGNMENTBATCH'));
         *
         */
        $labelXml = $label->getDataRaw();

        $dom = new DOMDocument();
        $dom->loadXml($labelXml);

        $xpath = new \DOMXPath($dom);
        $styleLocation = $xpath->evaluate('string(//processing-instruction()[name() = "xml-stylesheet"])');
        $last = explode("\"", $styleLocation, 3);

        $xslLocation = $last[1];
        if($type === 'GET_MANIFEST') {
            $xslLocation = app_path('/Http/Transporters/Services/TNT/TNTRenderer.xsl');
        }

        // Load processor
        $xslt = new xsltProcessor;
        $dom->load($xslLocation);
        $xslt->importStyleSheet($dom);

        // Get combined
        $dom->loadXML($labelXml);
        $html = $xslt->transformToDoc($dom)->saveHTML();

        $filePath = storage_path('app/private/tnt/' . $fileName . '.pdf');

        try {
	        SnappyPdf::loadHtml($html)
		        ->setOption('image-dpi', '300')
		        ->setOption('image-quality', 100)
		        ->setOption('disable-smart-shrinking', null)
		        ->setOption('no-pdf-compression', null)
		        /** @https://doc.qt.io/archives/qt-4.8/qprinter.html#PaperSize-enum */
		        ->setOption('page-size', 'A4')
		        ->save($filePath);
        } catch (\Exception $e){}

        return $filePath;
    }

    public function getRequest(){
        return $this->data;
    }

}
