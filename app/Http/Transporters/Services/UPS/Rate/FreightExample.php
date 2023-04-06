<?php

namespace App\Http\Transporters\Services\UPS\Rate;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


class FreightExample
{

    public function getRates()
    {
        // Your UPS API credentials
    $accessKey = 'DD85D1B958DA7DF6';
    $username = 'improvo';
    $password = 'ih4jXfU12J6FCxMHErjvX6';

    $weight = 100; // The package weight in kg

    // The package weight in lbs
    $weightLbs = $weight * 2.20462;

    // Build the request data
    $data = [
        'UPSSecurity' => [
            'UsernameToken' => [
                'Username' => $username,
                'Password' => $password,
            ],
            'ServiceAccessToken' => [
                'AccessLicenseNumber' => $accessKey,
            ],
        ],
        'RateRequest' => [
            'Request' => [
                'RequestOption' => 'Shop',
            ],
            'Shipment' => [
                'Shipper' => [
                    'Address' => [
                        'PostalCode' => '90210',
                        'CountryCode' => 'US',
                    ],
                ],
                'ShipTo' => [
                    'Address' => [
                        'PostalCode' => '90210',
                        'CountryCode' => 'US',
                    ],
                ],
                'Package' => [
                    'PackagingType' => [
                        'Code' => '02',
                    ],
                    'PackageWeight' => [
                        'Weight' => $weightLbs,
                    ],
                ],
            ],
        ],
    ];

    // Send the API request and get the response
    $client = new Client();
    $response = $client->request('POST', 'https://onlinetools.ups.com/ship/v1/rating/Rate', [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => $data,
    ]);

    // Parse the response and extract the shipping cost
    $body = $response->getBody();
    $result = json_decode($body);
    $shippingCost = $result->RateResponse->RatedShipment->TotalCharges->MonetaryValue;

    // Return the shipping cost
    return $shippingCost;

    //     try {
    //         $response = $service->transporter->getRates($transporterData);
    //     } catch (\Exception $exception) {
    //         return $exception->getMessage();
    //     }
        
    //    return '<pre>' . print_r($response->getData(), true) . '</pre>';
    }
}