<?php

namespace App\Http\Transporters\Services\TNT\Shipment;

use Spatie\ArrayToXml\ArrayToXml;
use App\Http\Transporters\Services\TNT\TNTBaseResource;

class Resource extends TNTBaseResource
{
    /**
     * @return array
     */
    public function transform(): array {
        $conRef = $this->getConref();

        $exw = $this->data->getExw();
	    $paymentind = 'S';
        if ($exw){
        	$paymentind = 'R';
        }

        $body = [
            'LOGIN' => [
                'COMPANY' => $this->data->getAuthKey(),
                'PASSWORD' => $this->data->getAuthSecret(),
                'APPID' => 'IN',
                'APPVERSION' => '3.0',
            ],
            'CONSIGNMENTBATCH' => [
                'SENDER' => [
                    'COMPANYNAME' => ['_cdata' => ($this->data->getShipmentShipper()->getCompany() != '') ? $this->data->getShipmentShipper()->getCompany() : $this->data->getShipmentShipper()->getName() ],
                    'STREETADDRESS1' => ['_cdata' => $this->data->getShipmentShipper()->getStreetLines( 0 )],
                    'STREETADDRESS2' => ['_cdata' => $this->data->getShipmentShipper()->getStreetLines( 1 )],
                    'CITY' => ['_cdata' => $this->data->getShipmentShipper()->getCity('tnt')],
                    'POSTCODE' => ['_cdata' => $this->data->getShipmentShipper()->getZip('tnt')],
                    'COUNTRY' => ['_cdata' => $this->data->getShipmentShipper()->getCountryCode('tnt')],
                    'ACCOUNT' => ['_cdata' => $this->data->getAccountNumber()],
                    'CONTACTNAME' => ['_cdata' => $this->data->getShipmentShipper()->getName()],
                    'CONTACTDIALCODE' => ['_cdata' => substr($this->data->getShipmentShipper()->getPhone(), 0, 4)],
                    'CONTACTTELEPHONE' => substr($this->data->getShipmentShipper()->getPhone(), 4),
                    'CONTACTEMAIL' => ['_cdata' => $this->data->getShipmentShipper()->getEmail()],
                    'COLLECTION' => [
                        'COLLECTIONADDRESS' => [
                            'COMPANYNAME' => ['_cdata' => ($this->data->getShipmentShipper()->getCompany() != '') ? $this->data->getShipmentShipper()->getCompany() : $this->data->getShipmentShipper()->getName() ],
                            'STREETADDRESS1' => ['_cdata' => $this->data->getShipmentShipper()->getStreetLines( 0 )],
                            'STREETADDRESS2' => ['_cdata' => $this->data->getShipmentShipper()->getStreetLines( 1 )],
                            'CITY' => ['_cdata' => $this->data->getShipmentShipper()->getCity('tnt')],
                            'POSTCODE' => ['_cdata' => $this->data->getShipmentShipper()->getZip('tnt')],
                            'COUNTRY' => ['_cdata' => $this->data->getShipmentShipper()->getCountryCode('tnt')],
                            'CONTACTNAME' => ['_cdata' => $this->data->getShipmentShipper()->getName()],
                            'CONTACTDIALCODE' => ['_cdata' => substr($this->data->getShipmentShipper()->getPhone(), 0, 4)],
                            'CONTACTTELEPHONE' => substr($this->data->getShipmentShipper()->getPhone(), 4),
                            'CONTACTEMAIL' => ['_cdata' => $this->data->getShipmentShipper()->getEmail()],
                        ],
                        'SHIPDATE' => ['_cdata' => date('d/m/Y', strtotime($this->data->getShipmentDate()))],
                        'PREFCOLLECTTIME' => [
                            'FROM' => ['_cdata' => $this->getPickupFrom()],
                            'TO' => ['_cdata' => $this->getPickupTo()],
                        ],
                        'COLLINSTRUCTIONS' => ['_cdata' => $this->getCollInstructions()],
                    ]
                ],
                'CONSIGNMENT' => [
                    'CONREF' => $conRef,
                    'DETAILS' => [
                        'RECEIVER' => [
                            'COMPANYNAME' => ['_cdata' => ($this->data->getShipmentRecipient()->getCompany() != '') ? $this->data->getShipmentRecipient()->getCompany() : $this->data->getShipmentRecipient()->getName() ],
                            'STREETADDRESS1' => ['_cdata' => $this->data->getShipmentRecipient()->getStreetLines( 0 )],
                            'STREETADDRESS2' => ['_cdata' => $this->data->getShipmentRecipient()->getStreetLines( 1 )],
                            'CITY' => ['_cdata' => $this->data->getShipmentRecipient()->getCity('tnt')],
                            'POSTCODE' => ['_cdata' => $this->data->getShipmentRecipient()->getZip()],
                            'COUNTRY' => ['_cdata' => $this->data->getShipmentRecipient()->getCountryCode('tnt')],
                            'CONTACTNAME' => ['_cdata' => $this->data->getShipmentRecipient()->getName()],
                            'CONTACTDIALCODE' => ['_cdata' => substr($this->data->getShipmentRecipient()->getPhone(), 0, 4)],
                            'CONTACTTELEPHONE' => substr($this->data->getShipmentRecipient()->getPhone(), 4),
                            'CONTACTEMAIL' => ['_cdata' => $this->data->getShipmentRecipient()->getEmail()],
	                        'ACCOUNT' => ['_cdata' => $this->data->getExwAccount()],
                        ],
                        'DELIVERY' => [
                            'COMPANYNAME' => ['_cdata' => ($this->data->getShipmentRecipient()->getCompany() != '') ? $this->data->getShipmentRecipient()->getCompany() : $this->data->getShipmentRecipient()->getName()],
                            'STREETADDRESS1' => ['_cdata' => $this->data->getShipmentRecipient()->getStreetLines( 0 )],
                            'STREETADDRESS2' => ['_cdata' => $this->data->getShipmentRecipient()->getStreetLines( 1 )],
                            'CITY' => ['_cdata' => $this->data->getShipmentRecipient()->getCity('tnt')],
                            'POSTCODE' => ['_cdata' => $this->data->getShipmentRecipient()->getZip()],
                            'COUNTRY' => ['_cdata' => $this->data->getShipmentRecipient()->getCountryCode('tnt')],
                            'CONTACTNAME' => ['_cdata' => $this->data->getShipmentRecipient()->getName()],
                            'CONTACTDIALCODE' => ['_cdata' => substr($this->data->getShipmentRecipient()->getPhone(), 0, 4)],
                            'CONTACTTELEPHONE' => substr($this->data->getShipmentRecipient()->getPhone(), 4),
                            'CONTACTEMAIL' => ['_cdata' => $this->data->getShipmentRecipient()->getEmail()],
                        ],
                        'CUSTOMERREF' => ['_cdata' => $this->data->getShipmentReference()],
                        'CONTYPE' => ['_cdata' => 'N'],
                        'PAYMENTIND' => ['_cdata' => $paymentind],
                        'ITEMS' => $this->getTotalCollies(),
                        'TOTALWEIGHT' => $this->getTotalColliWeight(),
                        'TOTALVOLUME' => ['_cdata' => $this->getTotalColliVolume()],
                        'CURRENCY' => ['_cdata' => $this->data->getShipmentCurrency()],
                        'GOODSVALUE' => $this->data->getShipmentCustomValueAmount(),
                        'INSURANCEVALUE' => $this->data->getShipmentInsuranceValue(),
                        'INSURANCECURRENCY' => $this->data->getShipmentCurrency(),
                        'SERVICE' => $this->data->getShipmentService(),
                        'DESCRIPTION' => ['_cdata' => $this->data->getShipmentReference()],
                        'DELIVERYINST' => ['_cdata' => 'None'],
                        'PACKAGE' => $this->getColliLines()
                    ]
                ]
            ],
            'ACTIVITY' => [
                'CREATE' => [
                    'CONREF' => $conRef
                ],
                'BOOK' => [
                    '_attributes' => [
                        'ShowBookingRef' => 'Y'
                    ],
                    'CONREF' => $conRef
                ],
                'SHIP' => [
                    'CONREF' => $conRef
                ],
                'PRINT' => [
                    'CONNOTE' => [
                        'CONREF' => $conRef
                    ],
                    'LABEL' => [
                        'CONREF' => $conRef
                    ],
                    'MANIFEST' => [
                        'CONREF' => $conRef
                    ],
                ]
            ]
        ];

        if(!$this->data->getShipmentCustomValueAmount()) {
            // Unsetting values since this API expects a specific column order for a success response
            unset($body['CONSIGNMENTBATCH']['CONSIGNMENT']['DETAILS']['CURRENCY']);
            unset($body['CONSIGNMENTBATCH']['CONSIGNMENT']['DETAILS']['GOODSVALUE']);
        }

        if(!$this->data->getShipmentInsuranceValue()) {
            // Unsetting values since this API expects a specific column order for a success response
            unset($body['CONSIGNMENTBATCH']['CONSIGNMENT']['DETAILS']['INSURANCEVALUE']);
            unset($body['CONSIGNMENTBATCH']['CONSIGNMENT']['DETAILS']['INSURANCECURRENCY']);
        }

        $data = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'xml_in' => ArrayToXml::convert($body, 'ESHIPPER')
            ],
        ];

        return $data;
    }
}
