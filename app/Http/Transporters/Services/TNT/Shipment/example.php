<?php

namespace App\Http\Transporters\Services\TNT\Shipment;

class Example
{

    public function createShipment()
    {
        $service = new \App\Http\Transporters\TransporterService('tnt');

        $transporterData = new \App\Http\Transporters\Data\TransporterBaseData();
        $transporterData->setAuthKey('TBBLIVE123');
        $transporterData->setAuthSecret('TBBLIVE123');
        $transporterData->setAccountNumber('00256100');

        $transporterData->setShipmentService('48N');
        $transporterData->setCompanyId('1');
        $transporterData->setShipmentCurrency('EUR');
        $transporterData->setShipmentCustomValueAmount(10.00);
        $transporterData->setShipmentPickupTimeStart('09:00');
        $transporterData->setShipmentPickupTimeUntil('16:00');
        $transporterData->setShipmentReference('RP27520Z01');
        $transporterData->setShipmentPickupInstructions('Zijdeur');
        $transporterData->setShipmentDescription('Test Description');
        $transporterData->setShipmentDate(date('Y-m-d', strtotime(date('Y-m-d') . '+3 days')));
        $transporterData->setShipmentInsuranceValue(5.00);

        // Create colli
        $shipmentColli = new \App\Http\Transporters\Data\ShipmentColli();
        $shipmentColli->setAmount(1);
        $shipmentColli->setLength(1);
        $shipmentColli->setWidth(1);
        $shipmentColli->setHeight(1);
        $shipmentColli->setWeight(3);

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
        $shipmentShipperContactAddress->setName('Robbert Passieux');
        $shipmentShipperContactAddress->setCompany('Nihot Recycling Technology');
        $shipmentShipperContactAddress->setPhone('0205822030');
        $shipmentShipperContactAddress->addStreetLine('Electronstraat 20/c');
        $shipmentShipperContactAddress->setCity('Amsterdam');
        $shipmentShipperContactAddress->setZip('1014 AT');
        $shipmentShipperContactAddress->setCountryCode('NL');
        $shipmentShipperContactAddress->setEmail('robbertp@nihot.nl');

        // Add shipper to our global data object
        $transporterData->setShipmentShipper($shipmentShipperContactAddress);

        // Create recipient contact address
        $shipmentRecipientContactAddress = new \App\Http\Transporters\Data\ShipmentContactAddress();
        $shipmentRecipientContactAddress->setName('Logistics');
        $shipmentRecipientContactAddress->setCompany('Koppitz Entsorgungs GmbH');
        $shipmentRecipientContactAddress->setPhone('0049893104957');
        $shipmentRecipientContactAddress->addStreetLine('Klingenstraße 8');
        $shipmentRecipientContactAddress->setCity('Knetzgau');
        $shipmentRecipientContactAddress->setZip('97478');
        $shipmentRecipientContactAddress->setCountryCode('DE');
        $shipmentRecipientContactAddress->setEmail('a.hanke@et-bavaria.eu');

        // Add recipient to our global data object
        $transporterData->setShipmentRecipient($shipmentRecipientContactAddress);

        try {
            $response = $service->transporter->createShipment($transporterData);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        // Handle API errors for last request when all collis has been parsed
        if (!$response->isSuccess()) {
            return $response->getMessage();
        }

        /**
         * @optional Store label
         */
        $response->storeLabel($response->request->getTracking());

        // Success handler
        return $response;
    }
}
