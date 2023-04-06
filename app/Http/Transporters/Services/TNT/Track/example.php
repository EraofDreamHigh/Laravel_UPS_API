<?php

namespace App\Http\Transporters\Services\TNT\Track;

class Example
{

    public function getTrack()
    {
        $service = new \App\Http\Transporters\TransporterService('tnt');

        $transporterData = new \App\Http\Transporters\Data\TransporterBaseData();
        $transporterData->setAuthKey('TBBLIVE123');
        $transporterData->setAuthSecret('TBBLIVE123');
        $transporterData->setAccountNumber('00256100');
        $transporterData->setShipmentTracking('837096255');

        try {
            $response = $service->transporter->getTrack($transporterData);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        // Handle API errors
        if ($response->isSuccess()) {
            return $response->getData();
        }
    }
}
