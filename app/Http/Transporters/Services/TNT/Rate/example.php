<?php

namespace App\Http\Transporters\Services\TNT\Rate;

class Example
{

    public function getRates()
    {
        $service = new \App\Http\Transporters\TransporterService('tnt');

        $transporterData = new \App\Http\Transporters\Data\TransporterBaseData();
        $transporterData->setAuthKey('TBBLIVE123');
        $transporterData->setAuthSecret('TBBLIVE123');
        $transporterData->setAccountNumber('00256100');

        $transporterData->setShipmentDate(date('Y-m-d', strtotime(date('Y-m-d') . '+1 days')));
        $transporterData->setShipmentCurrency('EUR');
        $transporterData->setShipmentInsuranceValue(0.00);

        $shipmentColli = new \App\Http\Transporters\Data\ShipmentColli();
        $shipmentColli->setAmount(1);
        $shipmentColli->setLength(5);
        $shipmentColli->setWidth(5);
        $shipmentColli->setHeight(5);
        $shipmentColli->setWeight(5.50);

        $transporterData->addColli($shipmentColli);

        $shipmentColli = new \App\Http\Transporters\Data\ShipmentColli();
        $shipmentColli->setAmount(3);
        $shipmentColli->setLength(2);
        $shipmentColli->setWidth(6);
        $shipmentColli->setHeight(3);
        $shipmentColli->setWeight(6.50);

        $transporterData->addColli($shipmentColli);

        $shipmentShipperContactAddress = new \App\Http\Transporters\Data\ShipmentContactAddress();
        $shipmentShipperContactAddress->setCity('Amsterdam');
        $shipmentShipperContactAddress->setZip('1014 AT');
        $shipmentShipperContactAddress->setCountryCode('NL');

        $transporterData->setShipmentShipper($shipmentShipperContactAddress);

        $shipmentRecipientContactAddress = new \App\Http\Transporters\Data\ShipmentContactAddress();
        $shipmentRecipientContactAddress->setCity('Berlin');
        $shipmentRecipientContactAddress->setZip('13127');
        $shipmentRecipientContactAddress->setCountryCode('DE');

        $transporterData->setShipmentRecipient($shipmentRecipientContactAddress);

        try {
            $response = $service->transporter->getRates($transporterData);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        // Handle API errors
        if (!$response->isSuccess()) {
            return $response->getMessage();
        }

        return $response->getData();
    }
}
