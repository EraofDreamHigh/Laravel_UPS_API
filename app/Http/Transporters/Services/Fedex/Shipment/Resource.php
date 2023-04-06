<?php

namespace App\Http\Transporters\Services\Fedex\Shipment;

use App\Http\Transporters\Services\Fedex\FedexBaseResource;
use App\Http\Transporters\Rules\TransporterMustTransformInterface;
use Illuminate\Support\Facades\Log;

class Resource extends FedexBaseResource implements TransporterMustTransformInterface
{
    /**
     * Transform method
     * @return mixed
     */
    public function transform(): array
    {
        $data = [
            'auth' => [
                'authKey' => $this->data->getAuthKey(),
                'authSecret' => $this->data->getAuthSecret(),
            ],
            'data' => [
                'labelResponseOptions' => 'URL_ONLY',
                'requestedShipment' => [
                    'shipper' => [
                        'contact' => [
                            'personName' => $this->data->getShipmentShipper()->getName(),
                            'companyName' => $this->data->getShipmentShipper()->getCompany(),
                            'phoneNumber' => $this->data->getShipmentShipper()->getPhone(),
                        ],
                        'address' => [
                            'streetLines' => [$this->data->getShipmentShipper()->getStreetLines(), $this->data->getShipmentShipper()->getStreetLines(1)],
                            'city' => $this->data->getShipmentShipper()->getCity('fedex'),
                            'stateOrProvinceCode' => $this->data->getShipmentShipper()->getStateOrProvinceCode(),
                            'postalCode' => $this->data->getShipmentShipper()->getZip(),
                            'countryCode' => $this->data->getShipmentShipper()->getCountryCode('fedex'),
                        ]
                    ],
                    'recipients' => [
                        [
                            'contact' => [
                                'personName' => $this->data->getShipmentRecipient()->getName(),
                                'companyName' => 'Recipient Company',
                                'phoneNumber' => $this->data->getShipmentRecipient()->getPhone(),
                            ],
                            'address' => [
                                'streetLines' => [$this->data->getShipmentRecipient()->getStreetLines(), $this->data->getShipmentRecipient()->getStreetLines(1)],
                                'city' => $this->data->getShipmentRecipient()->getCity('fedex'),
                                'stateOrProvinceCode' => $this->data->getShipmentRecipient()->getStateOrProvinceCode(),
                                'postalCode' => $this->data->getShipmentRecipient()->getZip(),
                                'countryCode' => $this->data->getShipmentRecipient()->getCountryCode('fedex'),
                            ]
                        ]
                    ],
                    'shipDatestamp' => date('Y-m-d'),
                    'serviceType' => $this->data->getShipmentService(),
                    'packagingType' => $this->getShipmentType(),
                    "pickupType" => "USE_SCHEDULED_PICKUP",
                    'blockInsightVisibility' => false,
                    'shippingChargesPayment' => [
                        'paymentType' => 'SENDER'
                    ],
                    'labelSpecification' => [
                        'imageType' => 'PDF',
                        'labelStockType' => $this->getLabelType(),
                    ],
                    'customsClearanceDetail' => [
                        'dutiesPayment' => [
                            'paymentType' => 'SENDER'
                        ],
                        'isDocumentOnly' => false,
                        'commodities' => [
                            [
                                'description' => $this->data->getShipmentDescription(),
                                'countryOfManufacture' => 'NL',
                                'quantity' => 1,
                                'quantityUnits' => 'PCS',
                                'customsValue' => [
                                    'amount' => $this->data->getShipmentCustomValueAmount(),
                                    'currency' => $this->data->getShipmentCurrency()
                                ],
                                'unitPrice' => [
                                    'amount' => $this->data->getShipmentCustomValueAmount(),
                                    'currency' => $this->data->getShipmentCurrency()
                                ],
                                'weight' => [
                                    'units' => 'KG',
                                    'value' => round($this->data->getShipmentColli()->getWeight(), 1),
                                ],
                                
                            ]
                        ],
                    ],
                    'shippingDocumentSpecification' => [
                        'shippingDocumentTypes' => [
                            'COMMERCIAL_INVOICE'
                        ],
                        'commercialInvoiceDetail' => [
                            'documentFormat' => [
                                'stockType' => 'PAPER_LETTER',
                                'docType' => 'PDF'
                            ]
                        ]
                    ],
                    'requestedPackageLineItems' => [
                        [
                            'weight' => [
                                'units' => 'KG',
                                'value' => round($this->data->getShipmentColli()->getWeight(), 1)
                            ],
                            'dimensions' => [
                                'length' => $this->data->getShipmentColli()->getLength(),
                                'width' => $this->data->getShipmentColli()->getWidth(),
                                'height' => $this->data->getShipmentColli()->getHeight(),
                                'units' => 'CM'
                            ],
                        ]
                    ]
                ],
                'accountNumber' => [
                    'value' => $this->data->getAccountNumber(),
                ]
            ]
        ];

        return $data;
    }


    public function getLabelType()
    {
        return 'PAPER_85X11_TOP_HALF_LABEL';
        if ($this->data->getLabelTemplate() !== '') {
            return $this->data->getLabelTemplate();
        }
    }
}