<?php

namespace App\Http\Transporters\Services\UPS\Rate;

class Example
{

    public function getRates()
    {
        $service = new \App\Http\Transporters\TransporterService('ups');

        $transporterData = new \App\Http\Transporters\Data\TransporterBaseData();

        $transporterData->setAuthUsername('improvo');
        $transporterData->setAuthPassword('ih4jXfU12J6FCxMHErjvX6');
        $transporterData->setAuthKey('DD85D1B958DA7DF6');
        $transporterData->setAccountNumber('A0Y693');

        $transporterData->setShipmentDate('29-03-2023');
        $transporterData->setShipmentCurrency('EUR');
        $transporterData->setShipmentInsuranceValue(0.00);
        $transporterData->setShipmentReference('Referentie ABC');
        $transporterData->setCompanyId('Company ID');

        // Create colli
        $shipmentColli = new \App\Http\Transporters\Data\ShipmentColli();
        $shipmentColli->setAmount(1);
        $shipmentColli->setLength(5);
        $shipmentColli->setWidth(5);
        $shipmentColli->setHeight(5);
        $shipmentColli->setWeight(5.50);
        $shipmentColli->setType('01'); // 01 = Package (default

        // Add colli to our global data object
        $transporterData->addColli($shipmentColli);

        // Create shipper contact address
        $shipmentShipperContactAddress = new \App\Http\Transporters\Data\ShipmentContactAddress();
        $shipmentShipperContactAddress->setName('Dirk Eysink');
        $shipmentShipperContactAddress->setCompany('Nihot Recycling Technology');
        $shipmentShipperContactAddress->setPhone('0205822030');
        $shipmentShipperContactAddress->addStreetLine('Electronstraat 20/c');
        $shipmentShipperContactAddress->setCity('Amsterdam');
        $shipmentShipperContactAddress->setStateOrProvinceCode('NL');
        $shipmentShipperContactAddress->setZip('1014 AT');
        $shipmentShipperContactAddress->setCountryCode('NL');

        // Add shipper to our global data object
        $transporterData->setShipmentShipper($shipmentShipperContactAddress);

        // Create recipient contact address
        $shipmentRecipientContactAddress = new \App\Http\Transporters\Data\ShipmentContactAddress();
        $shipmentRecipientContactAddress->setName('MPS Betriebsführungsgeschellschaft');
        $shipmentRecipientContactAddress->addStreetLine('Am Vorwerk 7');
        $shipmentRecipientContactAddress->setCity('Berlin');
        $shipmentRecipientContactAddress->setStateOrProvinceCode('BE');
        $shipmentRecipientContactAddress->setZip('13127');
        $shipmentRecipientContactAddress->setCountryCode('DE');

        // Add recipient to our global data object
        $transporterData->setShipmentRecipient($shipmentRecipientContactAddress);
        //$transporterData->setShipmentService('INTERNATIONAL_PRIORITY');

        try {
            $response = $service->transporter->getRates($transporterData);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        
       return '<pre>' . print_r($response->getData(), true) . '</pre>';
    }
}