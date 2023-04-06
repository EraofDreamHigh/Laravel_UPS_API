<?php

$service = new \App\Http\Transporters\TransporterService('fedex');

$transporterData = new \App\Http\Transporters\Data\TransporterBaseData();
$transporterData->setAuthKey('l7be3d76e7300b41378988a29bdc53ea46');
$transporterData->setAuthSecret('db2952b09db141acafd750e242646cfb');

$transporterData->setInvoiceBase64File(base64_encode(file_get_contents(public_path('dummy.pdf'))));
$transporterData->setInvoiceFileName('dummy.pdf');
$transporterData->setInvoiceReference(\Illuminate\Support\Str::random(15));
$transporterData->setInvoiceOriginCountryCode('US');
$transporterData->setInvoiceDestinationCountryCode('US');

try {
    $response = $service->transporter->uploadDocument($transporterData);
} catch (Exception $exception) {
    return $exception->getMessage();
}
