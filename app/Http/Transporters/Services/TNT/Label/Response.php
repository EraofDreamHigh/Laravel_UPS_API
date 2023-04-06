<?php

namespace App\Http\Transporters\Services\TNT\Label;

use Barryvdh\DomPDF\PDF;
use DOMDocument;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use XSLTProcessor;
use App\Http\Transporters\Requests\TransporterRequestInterface;
use App\Http\Transporters\Responses\TransporterResponseAbstract;
use Barryvdh\Snappy\Facades\SnappyPdf;

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
    protected $raw;

    /**
     * Response constructor.
     * @param $data
     * @param TransporterRequestInterface $request
     */
    public function __construct($data, TransporterRequestInterface $request) {

        $this->raw = $data;
        $this->data = $this->xmlToObject($data);
        $this->request = $request;

    }

    /**
     * @return bool
     */
    public function isSuccess(): bool {
        if(!isset($this->data->consignment->pieceLabelData)) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     */ 
    public function getMessage(): string {
        return $this->raw;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int {
        return 200;
    }

    public function getData(){
    	return $this->data;
    }

    public function getPdf( $size = 'label' ){

	    $dom = new DOMDocument();
	    $dom->loadXml($this->raw);

	    // Load processor
	    $xslt = new XSLTProcessor();
	    $dom->load(app_path('/Http/Transporters/Services/TNT/Label/Xsl/HTMLRoutingLabelRenderer.xsl'));
	    $xslt->importStyleSheet($dom);
	    $xslt->setParameter('', 'barcode_url', 'https://express.tnt.com/barbecue/barcode?type=Code128C&height=140&width=2&data=');
	    $xslt->setParameter('', 'int2of5barcode_url', 'https://express.tnt.com/barbecue/barcode?type=Code128C&height=140&width=2&data=');
	    $xslt->setParameter('', 'code128Bbarcode_url', 'https://express.tnt.com/barbecue/barcode?type=Code128C&height=140&width=2&data=');
	    $xslt->setParameter('', 'twoDbarcode_url', 'https://express.tnt.com/barbecue/barcode?type=Code128C&height=140&width=2&data=');
	    $xslt->setParameter('', 'images_dir', 'https://express.tnt.com/expresswebservices-website/rendering/images');
	    $xslt->setParameter('', 'css_dir', asset('/assets/css/'));
 
	    // Get combined
	    $dom->loadXML($this->raw);
	    $html = $xslt->transformToDoc($dom)->saveHTML();

	    $html = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transistional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">','',$html);
	    $html = str_replace('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">','<html>',$html);
	    $html = str_replace('<br xmlns="" style="page-break-before:always">','<div style="page-break-before: always;"></div>',$html);
	    $html = str_replace('<div style="page-break-before: always;"></div></body>','</body>',$html);
	    if ($size == 'label') {

		    $html = str_replace('</title>', '
				</title>
		        <style>
					@page {
						margin: 0;
						padding: 0;
						size: 348px 505px;
					}
			 
					*{
						outline: none;
						font-family: Helvetica;
					} 
	
					body,html{
						padding: 0;
						margin: 0;
					}
					
					#pickupDateHeader{
						font-size: 9px !important;
						white-space: nowrap;
					}
					#optionDetail {
					    line-height: 100% !important; 
					}
					#originDepot span{
						display: inline-block !important;
						float: none;
						vertical-align: top;
					}
					#pickupDate{
						z-index: 10 !important;
						line-height: 90% !important;
					}
					#serviceDetail{
						font-size: 17px !important;
					}
				</style> 
		    ', $html);

	    }

//	    $filePath = storage_path('app/private/tnt/' . $fileName . '.pdf');
	    Storage::put('private/tnt/html/label' . $this->request->base->getShipmentTracking() . '.html', $html);

	    $file = 'label' . $this->request->base->getShipmentTracking() . '.pdf';

	    $pdf = app()->make('dompdf.wrapper');
	    $pdf->loadHTML( $html );
	    $pdf->save(storage_path('app/private/tnt/' . $file));

	    return $file;

    }

}
