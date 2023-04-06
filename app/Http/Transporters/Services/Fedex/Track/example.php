<?php

namespace App\Http\Transporters\Services\Fedex\Track;

class Example
{

    public function getTrack()
    {
        $service = new \App\Http\Transporters\TransporterService('fedex');

        $transporterData = new \App\Http\Transporters\Data\TransporterBaseData();
        $transporterData->setAuthKey('l7be3d76e7300b41378988a29bdc53ea46');
        $transporterData->setAuthSecret('db2952b09db141acafd750e242646cfb');
        $transporterData->setShipmentTracking('794949749373');

        try {
            $response = $service->transporter->getTrack($transporterData);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

        return $response->getData();

    }

}
