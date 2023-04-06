<?php

namespace App\Http\Transporters\Services\UPS\Custom;

use DOMDocument;
use Ups\Entity\Shipment;
use Ups\Entity\ShipmentRequestLabelSpecification;
use Ups\Entity\ShipmentRequestReceiptSpecification;

/**
 * Rate API Wrapper.
 *
 * @author Michael Williams <michael.williams@limelyte.com>
 */
class Shipping extends \Ups\Shipping
{
	private function createConfirmRequest(
		$validation,
		Shipment $shipment,
		ShipmentRequestLabelSpecification $labelSpec = null,
		ShipmentRequestReceiptSpecification $receiptSpec = null
	)
	{
		$xml = new DOMDocument();
		$xml->formatOutput = true;

		// Page 45
		$container = $xml->appendChild($xml->createElement('ShipmentConfirmRequest'));

		// Page 45
		$request = $container->appendChild($xml->createElement('Request'));

		$node = $xml->importNode($this->createTransactionNode(), true);
		$request->appendChild($node);

		$request->appendChild($xml->createElement('RequestAction', 'ShipConfirm'));
		$request->appendChild($xml->createElement('RequestOption', $validation ?: 'nonvalidate'));

		// Page 47
		$shipmentNode = $container->appendChild($xml->createElement('Shipment'));

		if ($shipment->getDescription()) {
			$shipmentNode->appendChild($xml->createElement('Description', $shipment->getDescription()));
		}

		$returnService = $shipment->getReturnService();
		if (isset($returnService)) {
			$node = $shipmentNode->appendChild($xml->createElement('ReturnService'));

			$node->appendChild($xml->createElement('Code', $returnService->getCode()));
		}

		if ($shipment->getDocumentsOnly()) {
			$shipmentNode->appendChild($xml->createElement('DocumentsOnly'));
		}

		$shipperNode = $shipmentNode->appendChild($xml->createElement('Shipper'));

		$shipperNode->appendChild($xml->createElement('Name', $shipment->getShipper()->getName()));

		if ($shipment->getShipper()->getAttentionName()) {
			$shipperNode->appendChild($xml->createElement('AttentionName', $shipment->getShipper()->getAttentionName()));
		}

		if ($shipment->getShipper()->getCompanyName()) {
			$shipperNode->appendChild($xml->createElement('CompanyDisplayableName', $shipment->getShipper()->getCompanyName()));
		}

		$shipperNode->appendChild($xml->createElement('ShipperNumber', $shipment->getShipper()->getShipperNumber()));

		if ($shipment->getShipper()->getTaxIdentificationNumber()) {
			$shipperNode->appendChild($xml->createElement('TaxIdentificationNumber', $shipment->getShipper()->getTaxIdentificationNumber()));
		}

		if ($shipment->getShipper()->getPhoneNumber()) {
			$shipperNode->appendChild($xml->createElement('PhoneNumber', $shipment->getShipper()->getPhoneNumber()));
		}

		if ($shipment->getShipper()->getFaxNumber()) {
			$shipperNode->appendChild($xml->createElement('FaxNumber', $shipment->getShipper()->getFaxNumber()));
		}

		if ($shipment->getShipper()->getEMailAddress()) {
			$shipperNode->appendChild($xml->createElement('EMailAddress', $shipment->getShipper()->getEMailAddress()));
		}

		$shipperNode->appendChild($shipment->getShipper()->getAddress()->toNode($xml));

		$shipToNode = $shipmentNode->appendChild($xml->createElement('ShipTo'));

		$shipToNode->appendChild($xml->createElement('CompanyName', $shipment->getShipTo()->getCompanyName()));

		if ($shipment->getShipTo()->getAttentionName()) {
			$shipToNode->appendChild($xml->createElement('AttentionName', $shipment->getShipTo()->getAttentionName()));
		}

		if ($shipment->getShipTo()->getPhoneNumber()) {
			$shipToNode->appendChild($xml->createElement('PhoneNumber', $shipment->getShipTo()->getPhoneNumber()));
		}

		if ($shipment->getShipTo()->getFaxNumber()) {
			$shipToNode->appendChild($xml->createElement('FaxNumber', $shipment->getShipTo()->getFaxNumber()));
		}

		if ($shipment->getShipTo()->getEMailAddress()) {
			$shipToNode->appendChild($xml->createElement('EMailAddress', $shipment->getShipTo()->getEMailAddress()));
		}

		$addressNode = $shipment->getShipTo()->getAddress()->toNode($xml);

		if ($shipment->getShipTo()->getLocationID()) {
			$addressNode->appendChild($xml->createElement('LocationID', strtoupper($shipment->getShipTo()->getLocationID())));
		}

		$shipToNode->appendChild($addressNode);

		if ($shipment->getShipFrom()) {
			$shipFromNode = $shipmentNode->appendChild($xml->createElement('ShipFrom'));

			$shipFromNode->appendChild($xml->createElement('CompanyName', $shipment->getShipFrom()->getCompanyName()));

			if ($shipment->getShipFrom()->getAttentionName()) {
				$shipFromNode->appendChild($xml->createElement('AttentionName', $shipment->getShipFrom()->getAttentionName()));
			}

			if ($shipment->getShipFrom()->getPhoneNumber()) {
				$shipFromNode->appendChild($xml->createElement('PhoneNumber', $shipment->getShipFrom()->getPhoneNumber()));
			}

			if ($shipment->getShipFrom()->getFaxNumber()) {
				$shipFromNode->appendChild($xml->createElement('FaxNumber', $shipment->getShipFrom()->getFaxNumber()));
			}

			$shipFromNode->appendChild($shipment->getShipFrom()->getAddress()->toNode($xml));
		}

		if ($shipment->getSoldTo()) {
			$soldToNode = $shipmentNode->appendChild($xml->createElement('SoldTo'));

			if ($shipment->getSoldTo()->getOption()) {
				$soldToNode->appendChild($xml->createElement('Option', $shipment->getSoldTo()->getOption()));
			}

			$soldToNode->appendChild($xml->createElement('CompanyName', $shipment->getSoldTo()->getCompanyName()));

			if ($shipment->getSoldTo()->getAttentionName()) {
				$soldToNode->appendChild($xml->createElement('AttentionName', $shipment->getSoldTo()->getAttentionName()));
			}

			if ($shipment->getSoldTo()->getPhoneNumber()) {
				$soldToNode->appendChild($xml->createElement('PhoneNumber', $shipment->getSoldTo()->getPhoneNumber()));
			}

			if ($shipment->getSoldTo()->getFaxNumber()) {
				$soldToNode->appendChild($xml->createElement('FaxNumber', $shipment->getSoldTo()->getFaxNumber()));
			}

			if ($shipment->getSoldTo()->getAddress()) {
				$soldToNode->appendChild($shipment->getSoldTo()->getAddress()->toNode($xml));
			}
		}

		$alternate = $shipment->getAlternateDeliveryAddress();
		if (isset($alternate)) {
			$shipmentNode->appendChild($alternate->toNode($xml));
		}

		if ($shipment->getPaymentInformation()) {
			$paymentNode = $shipmentNode->appendChild($xml->createElement('PaymentInformation'));

			if ($shipment->getPaymentInformation()->getPrepaid()) {
				$node = $paymentNode->appendChild($xml->createElement('Prepaid'));
				$node = $node->appendChild($xml->createElement('BillShipper'));

				$billShipper = $shipment->getPaymentInformation()->getPrepaid()->getBillShipper();
				if (isset($billShipper) && $shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getAccountNumber()) {
					$node->appendChild($xml->createElement('AccountNumber', $shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getAccountNumber()));
				} elseif (isset($billShipper) && $shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getCreditCard()) {
					$ccNode = $node->appendChild($xml->createElement('CreditCard'));
					$ccNode->appendChild($xml->createElement('Type', $shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getCreditCard()->getType()));
					$ccNode->appendChild($xml->createElement('Number', $shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getCreditCard()->getNumber()));
					$ccNode->appendChild($xml->createElement('ExpirationDate', $shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getCreditCard()->getExpirationDate()));

					if ($shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getCreditCard()->getSecurityCode()) {
						$ccNode->appendChild($xml->createElement('SecurityCode', $shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getCreditCard()->getSecurityCode()));
					}

					if ($shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getCreditCard()->getAddress()) {
						$ccNode->appendChild($shipment->getPaymentInformation()->getPrepaid()->getBillShipper()->getCreditCard()->getAddress()->toNode($xml));
					}
				}
			} elseif ($shipment->getPaymentInformation()->getBillThirdParty()) {
				$node = $paymentNode->appendChild($xml->createElement('BillThirdParty'));
				$btpNode = $node->appendChild($xml->createElement('BillThirdPartyShipper'));
				$btpNode->appendChild($xml->createElement('AccountNumber', $shipment->getPaymentInformation()->getBillThirdParty()->getAccountNumber()));

				$tpNode = $btpNode->appendChild($xml->createElement('ThirdParty'));
				$addressNode = $tpNode->appendChild($xml->createElement('Address'));

				$thirdPartAddress = $shipment->getPaymentInformation()->getBillThirdParty()->getThirdPartyAddress();
				if (isset($thirdPartAddress) && $shipment->getPaymentInformation()->getBillThirdParty()->getThirdPartyAddress()->getPostalCode()) {
					$addressNode->appendChild($xml->createElement('PostalCode', $shipment->getPaymentInformation()->getBillThirdParty()->getThirdPartyAddress()->getPostalCode()));
				}

				$addressNode->appendChild($xml->createElement('CountryCode', $shipment->getPaymentInformation()->getBillThirdParty()->getThirdPartyAddress()->getCountryCode()));
			} elseif ($shipment->getPaymentInformation()->getFreightCollect()) {
				$node = $paymentNode->appendChild($xml->createElement('FreightCollect'));
				$brNode = $node->appendChild($xml->createElement('BillReceiver'));
				$brNode->appendChild($xml->createElement('AccountNumber', $shipment->getPaymentInformation()->getFreightCollect()->getAccountNumber()));

				if ($shipment->getPaymentInformation()->getFreightCollect()->getBillReceiverAddress()) {
					$addressNode = $brNode->appendChild($xml->createElement('Address'));
					$addressNode->appendChild($xml->createElement('PostalCode', $shipment->getPaymentInformation()->getFreightCollect()->getBillReceiverAddress()->getPostalCode()));
				}
			} elseif ($shipment->getPaymentInformation()->getConsigneeBilled()) {
				$paymentNode->appendChild($xml->createElement('ConsigneeBilled'));
			}
		} elseif ($shipment->getItemizedPaymentInformation()) {
			$paymentNode = $shipmentNode->appendChild($xml->createElement('ItemizedPaymentInformation'));

			for ($shipmentChargeRec = 1; $shipmentChargeRec <= 2; $shipmentChargeRec++) {
				if ($shipmentChargeRec === 1) {
					$rec = $shipment->getItemizedPaymentInformation()->getTransportationShipmentCharge();
					if ($rec == null) {
						continue;
					}
					$node = $paymentNode->appendChild($xml->createElement('ShipmentCharge'));
					$node->appendChild($xml->createElement('Type', \Ups\Entity\ShipmentCharge::TYPE_BILL_RECEIVER));
				} else {
					$rec = $shipment->getItemizedPaymentInformation()->getDutiesAndTaxesShipmentCharge();
					if ($rec == null) {
						continue;
					}
					$node = $paymentNode->appendChild($xml->createElement('ShipmentCharge'));
					$node->appendChild($xml->createElement('Type', \Ups\Entity\ShipmentCharge::TYPE_BILL_RECEIVER));
				}

				if ($rec->getBillShipper()) {
					$node = $node->appendChild($xml->createElement('BillShipper'));

					$billShipper = $rec->getBillShipper();
					if (isset($billShipper) && $rec->getBillShipper()->getAccountNumber()) {
						$node->appendChild($xml->createElement('AccountNumber', $rec->getBillShipper()->getAccountNumber()));
					} elseif (isset($billShipper) && $rec->getBillShipper()->getCreditCard()) {
						$ccNode = $node->appendChild($xml->createElement('CreditCard'));
						$ccNode->appendChild($xml->createElement('Type', $rec->getBillShipper()->getCreditCard()->getType()));
						$ccNode->appendChild($xml->createElement('Number', $rec->getBillShipper()->getCreditCard()->getNumber()));
						$ccNode->appendChild($xml->createElement('ExpirationDate', $rec->getBillShipper()->getCreditCard()->getExpirationDate()));

						if ($rec->getBillShipper()->getCreditCard()->getSecurityCode()) {
							$ccNode->appendChild($xml->createElement('SecurityCode', $rec->getBillShipper()->getCreditCard()->getSecurityCode()));
						}

						if ($rec->getBillShipper()->getCreditCard()->getAddress()) {
							$ccNode->appendChild($rec->getBillShipper()->getCreditCard()->getAddress()->toNode($xml));
						}
					}
				} elseif ($rec->getBillReceiver()) {
					// TODO not done yet
				} elseif ($rec->getBillThirdParty()) {
					$node = $node->appendChild($xml->createElement('BillThirdParty'));
					$btpNode = $node->appendChild($xml->createElement('BillThirdPartyShipper'));
					$btpNode->appendChild($xml->createElement('AccountNumber', $rec->getBillThirdParty()->getAccountNumber()));

					$tpNode = $btpNode->appendChild($xml->createElement('ThirdParty'));
					$addressNode = $tpNode->appendChild($xml->createElement('Address'));

					$thirdPartAddress = $rec->getBillThirdParty()->getThirdPartyAddress();
					if (isset($thirdPartAddress) && $rec->getBillThirdParty()->getThirdPartyAddress()->getPostalCode()) {
						$addressNode->appendChild($xml->createElement('PostalCode', $rec->getBillThirdParty()->getThirdPartyAddress()->getPostalCode()));
					}

					$addressNode->appendChild($xml->createElement('CountryCode', $rec->getBillThirdParty()->getThirdPartyAddress()->getCountryCode()));
				} elseif ($rec->getConsigneeBilled()) {
					$node->appendChild($xml->createElement('ConsigneeBilled'));
				}
			}
			if ($shipment->getItemizedPaymentInformation()->getSplitDutyVATIndicator()) {
				$paymentNode->appendChild($xml->createElement('SplitDutyVATIndicator'));
			}
		}

		if ($shipment->getGoodsNotInFreeCirculationIndicator()) {
			$shipmentNode->appendChild($xml->createElement('GoodsNotInFreeCirculationIndicator'));
		}

		if ($shipment->getMovementReferenceNumber()) {
			$shipmentNode->appendChild($xml->createElement('MovementReferenceNumber', $shipment->getMovementReferenceNumber()));
		}

		$serviceNode = $shipmentNode->appendChild($xml->createElement('Service'));
		$serviceNode->appendChild($xml->createElement('Code', $shipment->getService()->getCode()));

		if ($shipment->getService()->getDescription()) {
			$serviceNode->appendChild($xml->createElement('Description', $shipment->getService()->getDescription()));
		}

		if ($shipment->getInvoiceLineTotal()) {
			$shipmentNode->appendChild($shipment->getInvoiceLineTotal()->toNode($xml));
		}

		if ($shipment->getNumOfPiecesInShipment()) {
			$shipmentNode->appendChild($xml->createElement('NumOfPiecesInShipment', $shipment->getNumOfPiecesInShipment()));
		}

		if ($shipment->getNumOfPiecesInShipment()) {
			$shipmentNode->appendChild($xml->createElement('NumOfPieces', $shipment->getNumOfPiecesInShipment()));
		}

		if ($shipment->getRateInformation()) {
			$node = $shipmentNode->appendChild($xml->createElement('RateInformation'));
			$node->appendChild($xml->createElement('NegotiatedRatesIndicator'));
		}

		foreach ($shipment->getPackages() as $package) {
			$shipmentNode->appendChild($xml->importNode($package->toNode($xml), true));
		}

		$shipmentServiceOptions = $shipment->getShipmentServiceOptions();
		if (isset($shipmentServiceOptions)) {
			$shipmentNode->appendChild($shipmentServiceOptions->toNode($xml));
		}

		$referenceNumber = $shipment->getReferenceNumber();
		if (isset($referenceNumber)) {
			$shipmentNode->appendChild($referenceNumber->toNode($xml));
		}

		$referenceNumber2 = $shipment->getReferenceNumber2();
		if (isset($referenceNumber2)) {
			$shipmentNode->appendChild($referenceNumber2->toNode($xml));
		}

		if ($labelSpec) {
			$container->appendChild($xml->importNode($this->compileLabelSpecificationNode($labelSpec), true));
		}

		$shipmentIndicationType = $shipment->getShipmentIndicationType();
		if (isset($shipmentIndicationType)) {
			$shipmentNode->appendChild($shipmentIndicationType->toNode($xml));
		}

		if ($receiptSpec) {
			$container->appendChild($xml->importNode($this->compileReceiptSpecificationNode($receiptSpec), true));
		}

		if ($shipment->getLocale()) {
			$shipmentNode->appendChild($xml->createElement('Locale', $shipment->getLocale()));
		}
		return $xml->saveXML();
	}

	/**
	 * @param ShipmentRequestLabelSpecification $labelSpec
	 * @return \DOMNode
	 */
	private function compileLabelSpecificationNode(ShipmentRequestLabelSpecification $labelSpec)
	{
		$xml = new DOMDocument();
		$xml->formatOutput = true;

		$labelSpecNode = $xml->appendChild($xml->createElement('LabelSpecification'));

		$printMethodNode = $labelSpecNode->appendChild($xml->createElement('LabelPrintMethod'));
		$printMethodNode->appendChild($xml->createElement('Code', $labelSpec->getPrintMethodCode()));

		if ($labelSpec->getPrintMethodDescription()) {
			$printMethodNode->appendChild($xml->createElement('Description', $labelSpec->getPrintMethodDescription()));
		}

		if ($labelSpec->getHttpUserAgent()) {
			$labelSpecNode->appendChild($xml->createElement('HTTPUserAgent', $labelSpec->getHttpUserAgent()));
		}

		//Label print method is required only for GIF label formats
		if ($labelSpec->getPrintMethodCode() == ShipmentRequestLabelSpecification::IMG_FORMAT_CODE_GIF) {
			$imageFormatNode = $labelSpecNode->appendChild($xml->createElement('LabelImageFormat'));
			$imageFormatNode->appendChild($xml->createElement('Code', $labelSpec->getImageFormatCode()));

			if ($labelSpec->getImageFormatDescription()) {
				$imageFormatNode->appendChild($xml->createElement('Description', $labelSpec->getImageFormatDescription()));
			}
		} else {
			//Label stock size is required only for non-GIF label formats
			$stockSizeNode = $labelSpecNode->appendChild($xml->createElement('LabelStockSize'));

			$stockSizeNode->appendChild($xml->createElement('Height', $labelSpec->getStockSizeHeight()));
			$stockSizeNode->appendChild($xml->createElement('Width', $labelSpec->getStockSizeWidth()));
		}

		if ($labelSpec->getInstructionCode()) {
			$instructionNode = $labelSpecNode->appendChild($xml->createElement('Instruction'));
			$instructionNode->appendChild($xml->createElement('Code', $labelSpec->getInstructionCode()));

			if ($labelSpec->getInstructionDescription()) {
				$instructionNode->appendChild($xml->createElement('Description', $labelSpec->getInstructionDescription()));
			}
		}

		if ($labelSpec->getCharacterSet()) {
			$labelSpecNode->appendChild($xml->createElement('CharacterSet', $labelSpec->getCharacterSet()));
		}

		return $labelSpecNode->cloneNode(true);
	}


	/**
	 * @param ShipmentRequestReceiptSpecification $receiptSpec
	 * @return \DOMNode
	 */
	private function compileReceiptSpecificationNode(ShipmentRequestReceiptSpecification $receiptSpec)
	{
		$xml = new DOMDocument();
		$xml->formatOutput = true;

		$receiptSpecNode = $xml->appendChild($xml->createElement('ReceiptSpecification'));

		$imageFormatNode = $receiptSpecNode->appendChild($xml->createElement('ImageFormat'));
		$imageFormatNode->appendChild($xml->createElement('Code', $receiptSpec->getImageFormatCode()));

		if ($receiptSpec->getImageFormatDescription()) {
			$imageFormatNode->appendChild($xml->createElement('Description', $receiptSpec->getImageFormatDescription()));
		}

		return $receiptSpecNode->cloneNode(true);
	}

}
