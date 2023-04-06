<?php

namespace App\Http\Transporters\Services\TNT\Label;

use App\Http\Transporters\Services\TNT\TNTBaseResource;

class Resource extends TNTBaseResource
{
    /**
     * @return array
     * https://express.tnt.com/expresswebservices-website/app/routinglabelrequest.html
     */
    public function transform(): array {

    	$lof = '1';
    	if (
    		strtolower($this->data->getShipmentShipper()->getCountryCode('tnt')) != 'nl'
    		|| strtolower($this->data->getShipmentRecipient()->getCountryCode('tnt')) != 'nl'
	    ){
		    $lof = '2';
	    }

    	$pieces = [];

    	$nr = 0;
	    foreach ($this->data->getShipmentCollies() as $colliNumber => $shipmentColli) {

	    	for( $a = 1; $a <= $shipmentColli->getAmount(); $a++) {

			    $nr ++;

			    $pieces[] = [
			    	
				    'identifier' => ['_cdata' => (string) $nr],
				    'goodsDescription' => (string) $this->data->getShipmentDescription(),

				    'pieceMeasurements' => [
					    'length' => ['_cdata' => (string) round($shipmentColli->getLength() / 100,2)],
					    'width' => ['_cdata' => (string) round($shipmentColli->getWidth() / 100,2)],
					    'height' => ['_cdata' => (string) round($shipmentColli->getHeight() / 100,2)],
					    'weight' => ['_cdata' => (string) $shipmentColli->getWeight()],
				    ],

				    'pieces' => [
					    'sequenceNumbers' => ['_cdata' => (string) $nr],
					    'pieceReference' => ['_cdata' => $this->data->getShipmentReference()],
				    ]

			    ];

		    }

	    }

	    switch( $this->data->getShipmentService()) {
        case '48N':
	        $product = 'EC';
        	break;
        case '412':
	        $product = 'EC12';
        	break;
        case '15N':
        case '15':
	        $product = 'EX';
        	break;
        case '09N':
        case '09':
	        $product = 'EX09';
        	break;
        case '10N':
        case '10':
	        $product = 'EX10';
        	break;
        case '12N':
        case '12':
	        $product = 'EX12';
        	break;
        case '99':
	        $product = 'IDMA';
        	break;
        case '130':
	        $product = 'IDMR';
        	break;
	    }

        $body = [
            'consignment' => [
	            'consignmentIdentity' => [
	                'consignmentNumber' => ['_cdata' => preg_replace('/[^0-9]/', '', $this->data->getShipmentTracking())],
	                'customerReference' => ['_cdata' => $this->data->getShipmentReference()],
                ],
	            'collectionDateTime' => ['_cdata' => date('Y-m-d\TH:i:s', strtotime($this->data->getShipmentDate())) ],
	            'sender' => [
		            'name' => ['_cdata' => substr($this->data->getShipmentShipper()->getCompany() . ' ' . $this->data->getShipmentShipper()->getName(), 0, 30) ],
		            'addressLine1' => ['_cdata' => $this->data->getShipmentShipper()->getStreetLines( 0 ) ],
		            'addressLine2' => ['_cdata' => $this->data->getShipmentShipper()->getStreetLines( 1 ) ],
		            'country' => ['_cdata' => $this->data->getShipmentShipper()->getCountryCode('tnt')],
		            'town' => ['_cdata' => $this->data->getShipmentShipper()->getCity('tnt')],
		            'postcode' => ['_cdata' => $this->data->getShipmentShipper()->getZip('tnt')],
	            ],
	            'delivery' => [
		            'name' => ['_cdata' => substr($this->data->getShipmentRecipient()->getCompany() . ' ' . $this->data->getShipmentRecipient()->getName(), 0, 30)],
		            'addressLine1' => ['_cdata' => $this->data->getShipmentRecipient()->getStreetLines( 0 ) ],
		            'addressLine2' => ['_cdata' => $this->data->getShipmentRecipient()->getStreetLines( 1 ) ],
		            'country' => ['_cdata' => $this->data->getShipmentRecipient()->getCountryCode('tnt')],
		            'town' => ['_cdata' => $this->data->getShipmentRecipient()->getCity('tnt')],
		            'postcode' => ['_cdata' => $this->data->getShipmentRecipient()->getZip('tnt')],
	            ],
	            'product' => [
	            	'lineOfBusiness' => ['_cdata' => (string) $lof],
	            	'groupId' => ['_cdata' => '0'],
	            	'subGroupId' => ['_cdata' => '0'],
	            	'id' => $product,
	            	'type' => ['_cdata' => 'N'],
	            	'option' => ['_cdata' => ''],
	            ],
	            'account' => [
		            'accountNumber' => ['_cdata' => $this->data->getAccountNumber()],
		            'accountCountry' => ['_cdata' => 'NL'],
	            ],
				'totalNumberOfPieces' => ['_cdata' => (string) $this->getTotalCollies()],
	            'pieceLine' => $pieces
            ],
        ];

        return $body;
    }
}
