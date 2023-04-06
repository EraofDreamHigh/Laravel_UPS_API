<?php

namespace App\Http\Transporters\Services\UPS\Shipment;

use App\Http\Transporters\Rules\TransporterMustTransformInterface;
use App\Http\Transporters\Services\UPS\UPSBaseResource;
use Ups\Entity\Address;
use Ups\Entity\DeliveryTimeInformation;
use Ups\Entity\Dimensions;
use Ups\Entity\InsuredValue;
use Ups\Entity\InternationalForms;
use Ups\Entity\ItemizedPaymentInformation;
use Ups\Entity\InvoiceLineTotal;
use Ups\Entity\Package;
use Ups\Entity\PackageServiceOptions;
use Ups\Entity\PackagingType;
use Ups\Entity\PaymentInformation;
use Ups\Entity\Product;
use Ups\Entity\RateInformation;
use Ups\Entity\ReferenceNumber;
use Ups\Entity\ReturnService;
use Ups\Entity\Service;
use Ups\Entity\ShipFrom;
use Ups\Entity\Shipment;
use Ups\Entity\ShipmentServiceOptions;
use Ups\Entity\ShipmentTotalWeight;
use Ups\Entity\ShipTo;
use Ups\Entity\SoldTo;
use Ups\Entity\Unit;
use Ups\Entity\UnitOfMeasurement;

class Resource extends UPSBaseResource implements TransporterMustTransformInterface
{

	public function prepair()
	{

		$shipment = new Shipment();

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
		$from->setAttentionName($this->data->getShipmentRecipient()->getName());
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

		## With the rates the code and name are combined, zo explode them here
		list($code, $name) = explode('-',$this->data->getShipmentService(),2);

		## Setting the service
		$service = new Service();
		$service->setCode( $code );
		$service->setDescription( $service->getName() );
		$shipment->setService($service);
		$shipment->setDescription( $this->data->getShipmentDescription() );

		if ( $this->data->getImport()) {

			$return = new ReturnService();
			$return->setCode(ReturnService::PRINT_RETURN_LABEL_PRL);
			$shipment->setReturnService($return);

		}

		// Set Reference Number
		$referenceNumber = new ReferenceNumber();
		$referenceNumber->setCode( ReferenceNumber::CODE_TRANSACTION_REFERENCE_NUMBER);
		$referenceNumber->setValue( $this->data->getShipmentReference() );
		$shipment->setReferenceNumber($referenceNumber);


		$referenceNumber2 = new ReferenceNumber();
		$referenceNumber2->setCode( ReferenceNumber::CODE_TRANSACTION_REFERENCE_NUMBER);
		$referenceNumber2->setValue( $this->data->getShipmentInvoiceReference() );
		$shipment->setReferenceNumber2($referenceNumber2);

		// Set payment information

		if ($this->data->getExw()){

			## Add FROM address
			$exwAddress = new Address();
			$exwAddress->setPostalCode($this->data->getShipmentExwAddress()->getZip());
			$exwAddress->setAddressLine1($this->data->getShipmentExwAddress()->getStreetLines());
			$exwAddress->setAddressLine2($this->data->getShipmentExwAddress()->getStreetLines(1));
			$exwAddress->setCity($this->data->getShipmentExwAddress()->getCity("ups"));
			$exwAddress->setStateProvinceCode($this->data->getShipmentExwAddress()->getStateOrProvinceCode());
			$exwAddress->setCountryCode($this->data->getShipmentExwAddress()->getCountryCode("ups"));

			$payment = new PaymentInformation(PaymentInformation::TYPE_BILL_THIRD_PARTY, (object)['AccountNumber' => $this->data->getExwAccount(), 'Address' => $exwAddress]);

		} else {

			$payment = new PaymentInformation( PaymentInformation::TYPE_PREPAID, (object)['AccountNumber' => $this->data->getAccountNumber()]);

		}

		// If invoice is filled in add InternationalForms for paperless invoice.
		if (!empty($this->data->getInvoiceBase64File())) {

			$internationalForms = new UpsInternationalForms();
			if ($this->data->getImport()){
				$internationalForms->setType(InternationalForms::TYPE_PARTIAL_INVOICE);
			} else {
				$internationalForms->setType(InternationalForms::TYPE_CUSTOMER_GENERATED_FORMS); 
			}
//			$internationalForms->setDeclarationStatement("I hereby certify that the information on this invoice is true and correct and the contents and value of this shipment is as stated above.");
			
			// afzender betaald zelf = 1, ontvanger betaald zelf = 0
			if ($this->data->getShipmentIsCustomDuty() == 1) { 
				$itemizedPaymentInformation = new ItemizedPaymentInformation();
				$itemizedPaymentInformation->setSplitDutyVATIndicator(true);
				$shipment->setItemizedPaymentInformation($itemizedPaymentInformation);
			} else {
				$itemizedPaymentInformation = new ItemizedPaymentInformation();
				$itemizedPaymentInformation->setSplitDutyVATIndicator(false);
				$shipment->setItemizedPaymentInformation($itemizedPaymentInformation);
			}

			# set use Ups\Entity\ItemizedPaymentInformation SplitDutyVATIndicator to true
		



			$internationalForms->setReasonForExport(\Ups\Entity\InternationalForms::RFE_SALE);  //TODO user choose this in the frontend
			$internationalForms->setInvoiceNumber($this->data->getInvoiceReference()); //Invoice Number
			$internationalForms->setCurrencyCode($this->data->getShipmentCurrency());
			$internationalForms->setDocumentId( $this->data->getDocumentID() );

			$invoiceDate 		= new \DateTime();
			$internationalForms->setInvoiceDate($invoiceDate);
			$internationalForms->setAdditionalDocumentIndicator(true);

			$soldTo = new SoldTo();
			$soldTo->setCompanyName($this->data->getShipmentRecipient()->getCompany());
			$soldTo->setAttentionName($this->data->getShipmentRecipient()->getName());
			$soldTo->setAddress($address);
			$soldTo->setEmailAddress($this->data->getShipmentRecipient()->getEmail());
			$soldTo->setPhoneNumber($this->data->getShipmentRecipient()->getPhone());
			$shipment->setSoldTo($soldTo);

		}

		$shipment->setPaymentInformation($payment);

		## Add collis
		$total = 0;
		foreach ($this->data->getShipmentCollies() as $nr => $colli) {

			for( $i = 1; $i <= $colli->getAmount(); $i ++ ) {

				$type = PackagingType::PT_PACKAGE;
				if ($colli->getType() == 'pallet') {
					$type = PackagingType::PT_PALLET;
//				} else if ($colli->getType() == 'document') {
//					$type = PackagingType::PT_PACKAGE;
				}

				## Add colli
				$package = new Package();
				$package->getPackagingType()->setCode($type);
				$package->getPackageWeight()->setWeight($colli->getWeight());
				$package->setDescription($this->data->getShipmentDescription());

				$weight = new UnitOfMeasurement();
				$weight->setCode('KGS');
				$package->getPackageWeight()->setUnitOfMeasurement($weight);

				$insured = new InsuredValue();
				$insured->setCurrencyCode($this->data->getShipmentCurrency());
				$insured->setMonetaryValue($colli->getInsurance());

				$options = new PackageServiceOptions();
				$options->setInsuredValue($insured);
				$package->setPackageServiceOptions($options);

				$dimensions = new Dimensions();
				$dimensions->setHeight($colli->getHeight());
				$dimensions->setWidth($colli->getWidth());
				$dimensions->setLength($colli->getLength());

				$unit = new UnitOfMeasurement;
				$unit->setCode('CM');

				$dimensions->setUnitOfMeasurement($unit);
				$package->setDimensions($dimensions);

				$shipment->addPackage($package);

				if (isset($internationalForms)) {

					$unitProduct = new Unit();
					$unitProduct->setValue($colli->getInsurance()); // todo ask if total of per amount?
					$unitProduct->setNumber($colli->getAmount());
					$unitProduct->setUnitOfMeasurement($unit);

					$product = new Product();
					$product->setOriginCountryCode($this->data->getInvoiceOriginCountryCode());
					$product->setDescription1($colli->getDescription());
					$product->setUnit($unitProduct);

					$internationalForms->addProduct($product);
				}

			}

			$total += $colli->getAmount();

		}

		$shipment->setNumOfPiecesInShipment( $total );


		$delivery = new DeliveryTimeInformation();
		$delivery->setPackageBillType(DeliveryTimeInformation::PBT_NON_DOCUMENT);
		$shipment->setDeliveryTimeInformation($delivery);


		$unit = new UnitOfMeasurement;
		$unit->setCode('KGS');

		$weight = new ShipmentTotalWeight();
		$weight->setWeight($this->getTotalColliWeight());
		$weight->setUnitOfMeasurement($unit);

		$shipment->setShipmentTotalWeight($weight);

		$total = new InvoiceLineTotal();
		$total->setCurrencyCode( $this->data->getShipmentCurrency() );
		$total->setMonetaryValue( $this->data->getShipmentCustomValueAmount() );

		$shipment->setInvoiceLineTotal( $total );

		$info = new RateInformation();
		$info->setNegotiatedRatesIndicator(1);
		$shipment->setRateInformation( $info );

		if (isset($internationalForms)) {
			$shipmentServiceOptions = new ShipmentServiceOptions();
			$shipmentServiceOptions->setInternationalForms($internationalForms);
			$shipment->setShipmentServiceOptions($shipmentServiceOptions);


		}
//		print_r($shipment);

		return $shipment;

	}

	public function transform(): array
	{
		return [];
	}

}
