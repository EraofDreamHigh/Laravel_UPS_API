<?php

namespace App\Http\Transporters\Services\TNT;

use Illuminate\Support\Str;
use App\Http\Transporters\Transformers\TransporterTransformerBase;

class TNTBaseResource extends TransporterTransformerBase
{
    /**
     * @return float|int
     */
    protected function getTotalColliWeight()
    {
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
     * @return float|int|string
     */
    protected function getTotalColliVolume()
    {
        $amount = 0;

        if (empty($this->data->getShipmentCollies())) {
            return $amount;
        }

        foreach ($this->data->getShipmentCollies() as $shipmentColli) {
            $amount += $shipmentColli->getAmount() * ($shipmentColli->getLength() * $shipmentColli->getWidth() * $shipmentColli->getHeight());
        }

        return (string) ($amount / 1000000);
    }

    /**
     * @return int
     */
    protected function getTotalCollies()
    {
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

        foreach ($this->data->getShipmentCollies() as $colliNumber => $shipmentColli) {
            $lines[] = [
                'ITEMS' => $shipmentColli->getAmount(),
                'DESCRIPTION' => $this->data->getShipmentDescription(),
                'LENGTH' => round($shipmentColli->getLength() / 100, 2),
                'HEIGHT' => round($shipmentColli->getHeight() / 100, 2),
                'WIDTH' => round($shipmentColli->getWidth() / 100, 2),
                'WEIGHT' => round($shipmentColli->getWeight(), 2)
            ];
        }

        return $lines;
    }

    /**
     * @return string
     */
    protected function getCollInstructions()
    {
        $location = 'None';

        if($this->data->getShipmentPickupOption() === 'pickup') {
            $location = $this->data->getShipmentPickupInstructions();
        }

        return $location;
    }

    /**
     * @return string
     */
    protected function getPickupFrom()
    {
        $pickupFrom = '12:00';

        if($this->data->getShipmentPickupOption() === 'pickup') {
            $pickupFrom = $this->data->getShipmentPickupTimeStart();
        }

        return $pickupFrom;
    }

    /**
     * @return string
     */
    protected function getPickupTo()
    {
        $pickupTo = '18:00';

        if($this->data->getShipmentPickupOption() === 'pickup') {
            $pickupTo = $this->data->getShipmentPickupTimeUntil();
        }

        return $pickupTo;
    }

    /**
     * @return string
     */
    protected function getConref()
    {
        return 'TBB' . Str::random(15);
    }
}
