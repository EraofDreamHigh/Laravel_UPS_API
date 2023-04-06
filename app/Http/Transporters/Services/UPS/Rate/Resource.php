<?php

namespace App\Http\Transporters\Services\UPS\Rate;

use App\Http\Transporters\Rules\TransporterMustTransformInterface;
use App\Http\Transporters\Services\UPS\UPSBaseResource;
use Ups\Entity\Address;
use Ups\Entity\DeliveryTimeInformation;
use Ups\Entity\Dimensions;
use Ups\Entity\InsuredValue;
use Ups\Entity\InvoiceLineTotal;
use Ups\Entity\Package;
use Ups\Entity\PackageServiceOptions;
use Ups\Entity\PackagingType;
use Ups\Entity\Pickup;
use Ups\Entity\RateInformation;
use Ups\Entity\ReturnService;
use Ups\Entity\ShipFrom;
use Ups\Entity\Shipment;
use Ups\Entity\ShipmentServiceOptions;
use Ups\Entity\ShipmentTotalWeight;
use Ups\Entity\ShipTo;
use Ups\Entity\UnitOfMeasurement;

class Resource extends UPSBaseResource implements TransporterMustTransformInterface
{

	public function prepair()
	{

		$shipment = new Shipment();

		$delivery = new DeliveryTimeInformation();

		$pickup = new Pickup();
		$pickup->setDate( date('Ymd', strtotime($this->data->getShipmentDate())) );
		$pickup->setTime(2200);

		$delivery->setPickup( $pickup );
		$delivery->setPackageBillType(DeliveryTimeInformation::PBT_NON_DOCUMENT);

		$shipment->setDeliveryTimeInformation( $delivery );

		## Add shipper
		if ( $this->data->getImport()) {

			## Add shipper
			$shipper = $shipment->getShipper();
			$shipper->setShipperNumber($this->data->getAccountNumber());
			$shipper->setName($this->data->getShipmentRecipient()->getCompany());
			$shipper->setAttentionName($this->data->getShipmentRecipient()->getName());

			$address = new Address();
			$address->setPostalCode($this->data->getShipmentRecipient()->getZip());
			$address->setAddressLine1($this->data->getShipmentRecipient()->getStreetLines());
			$address->setAddressLine2($this->data->getShipmentRecipient()->getStreetLines(1));
			$address->setCity($this->data->getShipmentRecipient()->getCity("ups"));
			$address->setStateProvinceCode($this->data->getShipmentRecipient()->getStateOrProvinceCode());
			$address->setCountryCode($this->data->getShipmentRecipient()->getCountryCode("ups"));

			$shipper->setAddress($address);
			$shipper->setEmailAddress($this->data->getShipmentRecipient()->getEmail());
			$shipper->setPhoneNumber($this->data->getShipmentRecipient()->getPhone());

		} else {

			## Add shipper
			$shipper = $shipment->getShipper();
			$shipper->setShipperNumber($this->data->getAccountNumber());
			$shipper->setName($this->data->getShipmentShipper()->getCompany());
			$shipper->setAttentionName($this->data->getShipmentShipper()->getName());

			$address = new Address();
			$address->setPostalCode($this->data->getShipmentShipper()->getZip());
			$address->setAddressLine1($this->data->getShipmentShipper()->getStreetLines());
			$address->setAddressLine2($this->data->getShipmentShipper()->getStreetLines(1));
			$address->setCity($this->data->getShipmentShipper()->getCity("ups"));
			$address->setStateProvinceCode($this->data->getShipmentShipper()->getStateOrProvinceCode());
			$address->setCountryCode($this->data->getShipmentShipper()->getCountryCode("ups"));

			$shipper->setAddress($address);
			$shipper->setEmailAddress($this->data->getShipmentShipper()->getEmail());
			$shipper->setPhoneNumber($this->data->getShipmentShipper()->getPhone());

		}

		$shipment->setShipper($shipper);

		## Add FROM address
		$address = new Address();
		$address->setPostalCode($this->data->getShipmentShipper()->getZip());
		$address->setAddressLine1($this->data->getShipmentShipper()->getStreetLines());
		$address->setAddressLine2($this->data->getShipmentShipper()->getStreetLines(1));
		$address->setCity($this->data->getShipmentShipper()->getCity("ups"));
		$address->setStateProvinceCode($this->data->getShipmentShipper()->getStateOrProvinceCode());
		$address->setCountryCode($this->data->getShipmentShipper()->getCountryCode("ups"));

		$from = new ShipFrom();
		$from->setCompanyName($this->data->getShipmentShipper()->getCompany());
		$from->setName($this->data->getShipmentShipper()->getName());
		$from->setAddress($address);
		$from->setEmailAddress($this->data->getShipmentShipper()->getEmail());
		$from->setPhoneNumber($this->data->getShipmentShipper()->getPhone());

		$shipment->setShipFrom($from);

		## Add TO address
		$address = new Address();
		$address->setPostalCode($this->data->getShipmentRecipient()->getZip());
		$address->setAddressLine1($this->data->getShipmentRecipient()->getStreetLines());
		$address->setAddressLine2($this->data->getShipmentRecipient()->getStreetLines(1));
		$address->setCity($this->data->getShipmentRecipient()->getCity("ups"));
		$address->setStateProvinceCode($this->data->getShipmentRecipient()->getStateOrProvinceCode());
		$address->setCountryCode($this->data->getShipmentRecipient()->getCountryCode("ups"));

		$to = new ShipTo();
		$to->setCompanyName($this->data->getShipmentRecipient()->getCompany());
		$to->setAttentionName($this->data->getShipmentRecipient()->getName());
		$to->setAddress($address);
		$to->setEmailAddress($this->data->getShipmentRecipient()->getEmail());
		$to->setPhoneNumber($this->data->getShipmentRecipient()->getPhone());

		$shipment->setShipTo($to);

		if ( $this->data->getImport()) {

			//$return = new ReturnService();
			//$return->setCode(ReturnService::PRINT_AND_MAIL_PNM);

			//$sop = new \App\Http\Transporters\Services\UPS\Custom\ShipmentServiceOptions();
			//$sop->setReturnService($return);

			//$shipment->setShipmentServiceOptions( $sop );

		}

		## Add collis
		$total = 0;
		foreach ($this->data->getShipmentCollies() as $nr => $colli) {

			for( $i = 1; $i <= $colli->getAmount(); $i ++ ){

				$type = PackagingType::PT_PACKAGE;
				if ($colli->getType() == 'pallet') {
					$type = PackagingType::PT_PALLET;
//				} else if ($colli->getType() == 'document') {
//					$type = PackagingType::PT_UPSLETTER;
				}

				## Add colli
				$package = new Package();
				$package->getPackagingType()->setCode($type);
				$package->setDescription($this->data->getShipmentDescription());
				//
				$weight = new UnitOfMeasurement();
				
				if ($this->data->getShipmentShipper()->getCountryCode("ups") !== 'US') {
					$weight->setCode('KGS');
					$package->getPackageWeight()->setWeight($colli->getWeight());
				} else {
					$weight->setCode('LBS');
					$package->getPackageWeight()->setWeight(round($colli->getWeight() * 2.20462262,2));
				}

				$package->getPackageWeight()->setUnitOfMeasurement($weight);

				$insured = new InsuredValue();
				$insured->setCurrencyCode($this->data->getShipmentCurrency());
				$insured->setMonetaryValue($colli->getInsurance());

				$options = new PackageServiceOptions();
				$options->setInsuredValue($insured);
				//$package->setPackageServiceOptions($options);

				$dimensions = new Dimensions();

				// change CM to FT
				
				

				$unit = new UnitOfMeasurement;
				if ($this->data->getShipmentShipper()->getCountryCode("ups") !== 'US') {
					$unit->setCode('CM');
					// length must be greater than width
					if ($colli->getLength() < $colli->getWidth()) {
						$dimensions->setHeight(round($colli->getWidth(), 2));
						$dimensions->setWidth(round($colli->getLength(), 2));
					} else {
						$dimensions->setHeight(round($colli->getLength(), 2));
						$dimensions->setWidth(round($colli->getWidth(), 2));
					}
					$dimensions->setLength(round($colli->getHeight(), 2));

				} else {
					// US: Inches
					$unit->setCode('IN');
					// length must be greater than width
					if ($dimensions->getLength() < $dimensions->getWidth()) {
						$dimensions->setHeight(round($colli->getWidth() * 0.393700787, 2));
						$dimensions->setWidth(round($colli->getLength() * 0.393700787, 2));
					} else {
						$dimensions->setHeight(round($colli->getLength() * 0.393700787, 2));
						$dimensions->setWidth(round($colli->getWidth() * 0.393700787, 2));
					}
					$dimensions->setLength(round($colli->getHeight() * 0.393700787, 2));
				}

				$dimensions->setUnitOfMeasurement($unit);
				$package->setDimensions($dimensions);

				$shipment->addPackage($package);

			}

			$total += $colli->getAmount();

		}

		$shipment->setNumOfPiecesInShipment( $total );
		$unit = new UnitOfMeasurement;
		$weight = new ShipmentTotalWeight();

		if ($this->data->getShipmentShipper()->getCountryCode("ups") !== 'US') {
			$unit->setCode('KGS');
			$weight->setWeight($this->getTotalColliWeight());
		} else {
			$unit->setCode('LBS');
			$weight->setWeight(round($this->getTotalColliWeight() * 2.20462262,2));
		}

		$weight->setUnitOfMeasurement($unit);

		$shipment->setShipmentTotalWeight($weight);

		$total = new InvoiceLineTotal();
		$total->setCurrencyCode($this->data->getShipmentCurrency());

		$customs = $this->data->getShipmentCustomValueAmount();
		if ($customs <= 0){
			$customs = 1;
		}
		$total->setMonetaryValue($customs);

		$shipment->setInvoiceLineTotal($total);

		$info = new RateInformation();
		$info->setNegotiatedRatesIndicator(1); 
		$shipment->setRateInformation( $info );

		//print_r($shipment);

		return $shipment;

	}

	public function transform(): array
	{
		return [];
	}

}
