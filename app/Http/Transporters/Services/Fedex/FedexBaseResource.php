<?php

namespace App\Http\Transporters\Services\Fedex;

use App\Http\Transporters\Transformers\TransporterTransformerBase;

class FedexBaseResource extends TransporterTransformerBase
{
    /**
     * @return bool
     */
    protected function isEnvelope() {
        if(empty($this->data->getShipmentCollies())) {
            return true;
        }

        foreach($this->data->getShipmentCollies() as $shipmentColli) {
            if($shipmentColli->getWeight() !== 0.3) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getType() {
        if (!empty($this->data->getShipmentDate()) && $this->data->getShipmentDate() === 'document') {
            if ($this->isEnvelope()) {
                return 'FEDEX_ENVELOPE';
            }
        }

        return 'YOUR_PACKAGING';
    }

    /**
     * @return float|int
     */
    protected function getTotalColliWeight() {
        $amount = 0;

        if (empty($this->data->getShipmentCollies())) {
            return $amount;
        }

        foreach ($this->data->getShipmentCollies() as $shipmentColli) {
            $amount += round((float) $shipmentColli->getAmount() * (float) $shipmentColli->getWeight(), 1);
        }

        return $amount;
    }

    /**
     * @return int
     */
    protected function getTotalCollis() {
        $amount = 0;

        if (empty($this->data->getShipmentCollies())) {
            return $amount;
        }

        foreach ($this->data->getShipmentCollies() as $shipmentColli) {
            $amount += $shipmentColli->getAmount();
        }

        return $amount;
    }

    /**
     * @return array
     */
    protected function getColliLines() {
        $lines = [];

        if (empty($this->data->getShipmentCollies())) {
            return $lines;
        }

        ## Check for freight
        $isfreight = false;

        foreach ($this->data->getShipmentCollies() as $colliNumber => $shipmentColli) {
            if ($shipmentColli->getWeight() > 68) {
                $isfreight = true;
                break;
            }
        }

        foreach ($this->data->getShipmentCollies() as $colliNumber => $shipmentColli) {
            ## In geval van vracht, check het gewicht
            if ($isfreight) {
                ## Colli kleiner dan 68, dan markeren als 68
                if ($shipmentColli->getWeight() < 68) {
                    $weight = 68;
                } else {
                    $weight = $shipmentColli->getWeight();
                }
           } else {
                $weight = $shipmentColli->getWeight();
           }

            $lines[strval($colliNumber)] = [
                //'SequenceNumber' => $colliNumber + 1,
                'groupPackageCount' => $shipmentColli->getAmount(),
                'weight' => [
                    'value' => $weight,
                    'units' => 'KG'
                ],
                'dimensions' => [
                    'length' => round($shipmentColli->getLength()),
                    'width' => round($shipmentColli->getWidth()),
                    'height' => round($shipmentColli->getHeight()),
                    'units' => 'CM'
                ],
                /*
                'CustomerReferences' => [
                	[
						'CustomerReferenceType' => 'CUSTOMER_REFERENCE',
						'Value' => $this->data->getShipmentReference()
					],
					[
						'CustomerReferenceType' => 'P_O_NUMBER',
						'Value' => $this->data->getShipmentInvoiceReference()
					]
                ]*/
            ];
        }

        return $lines;
    }

    /**
     * @return string
     */
    public function getShipmentType()
    {
        if ($this->data->getShipmentType() === 'document' && $this->isEnvelope()) {
            return 'FEDEX_ENVELOPE';
        }

        return 'YOUR_PACKAGING';
    }

    /**
     * @return array|null
     */
    public function getShipmentPayor()
    {
        if(!$this->data->getShipmentIsCustomDuty()) {
            return null;
        }

        return [
            'ResponsibleParty' => [
                'AccountNumber' => $this->data->getAccountNumber(),
                'Contact' => null,
                'Address' => [
                    'CountryCode' => $this->data->getShipmentShipper()->getCountryCode('fedex'),
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getShipmentReference()
    {
		return $this->data->getShipmentReference();
    }

    public function getShipmentTracking()
    {
        return $this->data->getShipmentTracking();
    }
}