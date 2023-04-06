<?php

namespace App\Http\Transporters\Services\UPS\Shipment;

use DOMDocument;
use DOMElement;

use Ups\Entity\InternationalForms;

class UpsInternationalForms extends InternationalForms
{

	private $documentId;

	public function setDocumentId($documentId){
		$this->documentId = $documentId;
	}

	public function getDocumentId(){
		return $this->documentId;
	}

	/**
	 * @param null|DOMDocument $document
	 *
	 * @return DOMElement
	 */
	public function toNode(DOMDocument $document = null)
	{
		if (null === $document) {
			$document = new DOMDocument();
		}

		$node = $document->createElement('InternationalForms');

		foreach ($this->getTypes() as $type) {
			$node->appendChild($document->createElement('FormType', $type));
		}
		if ($this->getInvoiceNumber() !== null) {
			$node->appendChild($document->createElement('InvoiceNumber', $this->getInvoiceNumber()));
		}
		if ($this->getInvoiceDate() !== null) {
			$node->appendChild($document->createElement('InvoiceDate', $this->getInvoiceDate()->format('Ymd')));
		}
		if ($this->getPurchaseOrderNumber() !== null) {
			$node->appendChild($document->createElement('PurchaseOrderNumber', $this->getPurchaseOrderNumber()));
		}
		if ($this->getTermsOfShipment() !== null) {
			$node->appendChild($document->createElement('TermsOfShipment', $this->getTermsOfShipment()));
		}
		if ($this->getReasonForExport() !== null) {
			$node->appendChild($document->createElement('ReasonForExport', $this->getReasonForExport()));
		}
		if ($this->getComments() !== null) {
			$node->appendChild($document->createElement('Comments', $this->getComments()));
		}
		if ($this->getDeclarationStatement() !== null) {
			$node->appendChild($document->createElement('DeclarationStatement', $this->getDeclarationStatement()));
		}
		if ($this->getDocumentId() !== null) {
			$userForm = $document->createElement('UserCreatedForm');
			$userForm->appendChild( $document->createElement('DocumentID', $this->getDocumentId()));
			$node->appendChild($userForm);
		}
		if ($this->getCurrencyCode() !== null) {
			$node->appendChild($document->createElement('CurrencyCode', $this->getCurrencyCode()));
		}
		if ($this->getDiscount() !== null) {
			$node->appendChild($this->getDiscount()->toNode($document));
		}
		if ($this->getFreightCharges() !== null) {
			$node->appendChild($this->getFreightCharges()->toNode($document));
		}
		if ($this->getAdditionalDocumentIndicator() !== null) {
			$node->appendChild($document->createElement('AdditionalDocumentIndicator'));
		}
		if ($this->getEEIFilingOption() !== null) {
			$node->appendChild($this->getEEIFilingOption()->toNode($document));
		}
		foreach ($this->getProducts() as $product) {
			$node->appendChild($product->toNode($document));
		}

		return $node;
	}

}