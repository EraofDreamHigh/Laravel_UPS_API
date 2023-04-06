<?php

namespace App\Http\Transporters\Services\UPS;

use App\Http\Transporters\Transformers\TransporterTransformerBase;

class UPSBaseResource extends TransporterTransformerBase
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

	protected function getOverWeight(){

		foreach ($this->data->getShipmentCollies() as $colli) {
			if ($colli->getWeight() > 32){
				return 'Y';
			}
		}
		return 'N';

	}

}
