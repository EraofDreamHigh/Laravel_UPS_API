<?php

namespace App\Http\Transporters\Services\UPS\FreightRate;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


class Example
{

    public function getRates()
    {
        $service = new \App\Http\Transporters\TransporterService('ups');

        $transporterData = new \App\Http\Transporters\Data\TransporterBaseData();

        /** Authentication */
        $transporterData->setAuthUsername('inprovo');
        $transporterData->setAuthPassword('ih4jXfU12J6FCxMHErjvX6');
        $transporterData->setAuthKey('DD85D1B958DA7DF6');
        $transporterData->setAccountNumber('A0Y693');

        // Create shipper contact address
        $shipmentShipperContactAddress = new \App\Http\Transporters\Data\ShipmentContactAddress();
        $shipmentShipperContactAddress->setZip('1014 AT');
        $shipmentShipperContactAddress->setCountryCode('NL');

        // Add shipper to our global data object
        $transporterData->setShipmentShipper($shipmentShipperContactAddress);
        
        $response = $service->transporter->getFreightRates($transporterData);
        
       return '<pre>' . print_r($response->getData(), true) . '</pre>';
    }
}