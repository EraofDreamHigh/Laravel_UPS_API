<?php

namespace App\Http\Transporters\Services\TNT\Pickup;

class Example
{

    public function createPickup()
    {
        $service = new \App\Http\Transporters\TransporterService('tnt');

        $transporterData = new \App\Http\Transporters\Data\TransporterBaseData();
        $transporterData->setShipmentDate(date('Y-m-d', strtotime(date('Y-m-d') . '+1 days')));

        try {
            $response = $service->transporter->getPickup($transporterData);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return $response->getData();
    }
}
