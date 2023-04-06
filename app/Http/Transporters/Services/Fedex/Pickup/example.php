<?php

namespace App\Http\Transporters\Services\Fedex\Pickup;

class Example
{

    public function createPickup()
    {
        $service = new \App\Http\Transporters\TransporterService('fedex');

        $transporterData = new \App\Http\Transporters\Data\TransporterBaseData();
        $transporterData->setAccountNumber('510087020');
        $transporterData->setAuthKey('l7be3d76e7300b41378988a29bdc53ea46');
        $transporterData->setAuthSecret('db2952b09db141acafd750e242646cfb');

        $transporterData->setShipmentPickupDate(date('Y-m-d', strtotime(date('Y-m-d') . '+1 days')));
        $transporterData->setShipmentPickupTimeStart('14:00');
        $transporterData->setShipmentPickupTimeUntil('17:00');

        // Create colli
        $shipmentColli = new \App\Http\Transporters\Data\ShipmentColli();
        $shipmentColli->setAmount(1);
        $shipmentColli->setLength(5);
        $shipmentColli->setWidth(5);
        $shipmentColli->setHeight(5);
        $shipmentColli->setWeight(5.50);

        // Add colli to our global data object
        $transporterData->addColli($shipmentColli);

        // Create colli 2
        $shipmentColli = new \App\Http\Transporters\Data\ShipmentColli();
        $shipmentColli->setAmount(2);
        $shipmentColli->setLength(3);
        $shipmentColli->setWidth(5);
        $shipmentColli->setHeight(6);
        $shipmentColli->setWeight(8.50);

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
        $shipmentRecipientContactAddress->setPhone('0205822030');
        $shipmentRecipientContactAddress->addStreetLine('Am Vorwerk 7');
        $shipmentRecipientContactAddress->setCity('Berlin');
        $shipmentRecipientContactAddress->setStateOrProvinceCode('BE');
        $shipmentRecipientContactAddress->setZip('13127');
        $shipmentRecipientContactAddress->setCountryCode('DE');

        // Add recipient to our global data object
        $transporterData->setShipmentRecipient($shipmentRecipientContactAddress);

        try {
            $response = $service->transporter->createPickup($transporterData);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        // Handle API errors
        if (!$response->isSuccess()) {
            return $response->getData();
        }

        // Success handler
        return $response->getData();
    }
}
