<?php

namespace App\Http\Transporters\Data;

class TransporterBaseData
{
    /**
     * @var string
     */
    private $shipmentID;
    /**
     * @var string
     */
    private $authKey;

    /**
     * @var string
     */
    private $authSecret;

    /**
     * @var string
     */
    private $authUsername;

    /**
     * @var string
     */
    private $authPassword;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $accountNumber;

    /**
     * @var string
     */
    private $depotNumber;

    /**
     * @var string
     */
    private $accountCode;

    /**
     * @var string
     */
    private $meterNumber;

    /**
     * @var string
     */
    private $shipmentDate;

    /**
     * @var string
     */
    private $shipmentCurrency;

    /**
     * @var array
     */
    private $shipmentCollies;

    /**
     * @var ShipmentColli
     */
    private $shipmentColli;

    /**
     * @var float
     */
    private $shipmentInsuranceValue;

    /**
     * @var ShipmentContactAddress
     */
    private $shipmentShipper;

    /**
     * @var ShipmentContactAddress
     */
    private $shipmentRecipient;

    /**
     * @var ShipmentContactAddress
     */
    private $shipmentExwAddress;

    /**
     * @var string
     */
    private $shipmentReference;


    private $shipmentInvoiceReference;

    /**
     * @var bool
     */
    private $shipmentIsCustomDuty;

    /**
     * @var string
     */
    private $shipmentDocumentContent;

    /**
     * @var float
     */
    private $shipmentCustomValueAmount;

    /**
     * @var string
     */
    private $shipmentDescription;

    /**
     * @var string
     */
    private $shipmentService;

    /**
     * @var string
     */
    private $shipmentType;

    /**
     * @var string
     */
    private $shipmentTracking;

    /**
     * @var string
     */
    private $shipmentPickupOption;

    /**
     * @var string
     */
    private $shipmentPickupLocation;

    /**
     * @var string
     */
    private $shipmentPickupTimeStart;

    /**
     * @var string
     */
    private $shipmentPickupTimeUntil;

    /**
     * @var string
     */
    private $shipmentPickupDate;

    /**
     * @var string
     */
    private $shipmentPickupInstructions;

    /**
     * @var string
     */
    private $companyId;

    /**
     * @var array
     */
    private $labels;

    /**
     * @var string
     */
    private $labelTemplate;

    /**
     * @var float
     */
    private $dimensionLengthLimit;

    /**
     * @var float
     */
    private $dimensionWidthLimit;

    /**
     * @var float
     */
    private $dimensionHeightLimit;

    /**
     * @var float
     */
    private $dimensionWeightLimit;

    /**
     * @var float
     */
    private $dimensionVolumeLimit;

    /**
     * @var float
     */
    private $tailgateWeightLimit;

    /**
     * @var float
     */
    private $rate;

    /**
     * @var string
     */
    private $invoiceBase64File;

    /**
     * @var string
     */
    private $invoiceFileName;

    /**
     * @var string
     */
    private $invoiceReference;

    /**
     * @var string
     */
    private $invoiceOriginCountryCode;

    /**
     * @var string
     */
    private $invoiceDestinationCountryCode;

    /**
     * @var string
     */
    private $serviceCollectionCode;

    /**
     * @var string
     */
    private $serviceCollectionSurcharge;

    /**
     * @var string
     */
    private $serviceDeliveryCode;

    /**
     * @var string
     */
    private $serviceDeliverySurcharge;

    /**
     * @var string
     */
    private $lifts;

    /**
     * @var float
     */
    private $totalDistance;

    /**
     * @var float
     */
    private $totalDuration;

    /**
     * @var float
     */
    private $exw;

    /**
     * @var float
     */
    private $exw_account;

    /**
     * @var float
     */
    private $document_id;


    private $import = false;

    private $pickupDistance = 0;
    private $pickupDuration = 0;

    private $maxImportDistance = 0;
    private $maxExportDistance = 0;

    /**
     * @return string
     */
    public function getShipmentDate(): string
    {
        if (!$this->shipmentDate) {
            return '';
        }

        return $this->shipmentDate;
    }

    /**
     * @return string
     */
    public function getShipmentID(): string
    {
        if (!$this->id) {
            return '';
        }

        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setShipmentID(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDocumentID(): string
    {
        if (!$this->document_id) {
            return '';
        }

        return $this->document_id;
    }

    /**
     * @param string $document_id
     */
    public function setDocumentID(string $document_id): void
    {
        $this->document_id = $document_id;
    }

    /**
     * @param string $shipmentDate
     */
    public function setShipmentDate(string $shipmentDate): void
    {
        $this->shipmentDate = $shipmentDate;
    }

    /**
     * @return string
     */
    public function getShipmentCurrency(): string
    {
        if (!$this->shipmentCurrency) {
            return '';
        }

        return $this->shipmentCurrency;
    }

    /**
     * @return string
     */
    public function getTotalDeclaredValue(): string
    {
       
    }

    /**
     * @param string $shipmentCurrency
     */
    public function setShipmentCurrency(string $shipmentCurrency): void
    {
        $this->shipmentCurrency = $shipmentCurrency;
    }

    /**
     * @param float $totalDistance
     */
    public function setTotalDistance(float $totalDistance): void
    {
        $this->totalDistance = $totalDistance;
    }

    /**
     * @param float $totalDuration
     */
    public function setTotalDuration(float $totalDuration): void
    {
        $this->totalDuration = $totalDuration;
    }

    /**
     * @return array
     */
    public function getShipmentCollies(): array
    {
        if (!$this->shipmentCollies) {
            return [];
        }

        return $this->shipmentCollies;
    }

    /**
     * @param array $shipmentCollies
     */
    public function setShipmentCollies(array $shipmentCollies): void
    {
        $this->shipmentCollies = $shipmentCollies;
    }

    /**
     * @return float
     */
    public function getShipmentInsuranceValue(): float
    {
        if (!$this->shipmentInsuranceValue) {
            return 0;
        }

        return $this->shipmentInsuranceValue;
    }

    /**
     * @param float $shipmentInsuranceValue
     */
    public function setShipmentInsuranceValue(float $shipmentInsuranceValue): void
    {
        $this->shipmentInsuranceValue = $shipmentInsuranceValue;
    }

    /**
     * @return ShipmentContactAddress
     */
    public function getShipmentShipper(): ShipmentContactAddress
    {
        if (!$this->shipmentShipper) {
            return new ShipmentContactAddress();
        }

        return $this->shipmentShipper;
    }

    /**
     * @param ShipmentContactAddress $shipmentShipper
     */
    public function setShipmentShipper(ShipmentContactAddress $shipmentShipper): void
    {
        $this->shipmentShipper = $shipmentShipper;
    }

    /**
     * @return ShipmentContactAddress $shipmentRecipient
     */
    public function getShipmentRecipient(): ShipmentContactAddress
    {
        if (!$this->shipmentRecipient) {
            return new ShipmentContactAddress();
        }

        return $this->shipmentRecipient;
    }

    /**
     * @param ShipmentContactAddress $shipmentRecipient
     */
    public function setShipmentRecipient(ShipmentContactAddress $shipmentRecipient): void
    {
        $this->shipmentRecipient = $shipmentRecipient;
    }

    /**
     * @return string
     */
    public function getShipmentReference(): string
    {
        if (!$this->shipmentReference) {
            return '';
        }

        return $this->shipmentReference;
    }

    /**
     * @param string $shipmentReference
     */
    public function setShipmentReference(string $shipmentReference): void
    {
        $this->shipmentReference = $shipmentReference;
    }


    /**
     * @return string
     */
    public function getShipmentInvoiceReference(): string
    {
        if (!$this->shipmentInvoiceReference) {
            return '';
        }

        return $this->shipmentInvoiceReference;
    }

    /**
     * @param string $shipmentInvoiceReference
     */
    public function setShipmentInvoiceReference(string $shipmentInvoiceReference): void
    {
        $this->shipmentInvoiceReference = $shipmentInvoiceReference;
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        if (!$this->companyId) {
            return '';
        }

        return $this->companyId;
    }

    /**
     * @param string $companyId
     */
    public function setCompanyId(string $companyId): void
    {
        $this->companyId = $companyId;
    }

    /**
     * @return string
     */
    public function getID(): string
    {
        return $this->shipmentID;
    }

    /**
     * @param $id
     */
    public function setID($id): void
    {
        $this->shipmentID = $id;
    }

    public function getImport(): bool
    {
        return $this->import;
    }

    public function setImport($import): void
    {
        $this->import = $import;
    }

    public function setPickupDistance($pickupDistance): void
    {
        $this->pickupDistance = $pickupDistance;
    }

    public function getPickupDistance(): float
    {
        return $this->pickupDistance;
    }

    public function setPickupDuration($pickupDuration): void
    {
        $this->pickupDuration = $pickupDuration;
    }

    public function getPickupDuration(): float
    {
        return $this->pickupDuration;
    }

    public function setMaxImportDistance($maxImportDistance): void
    {
        $this->maxImportDistance = $maxImportDistance;
    }

    public function getMaxImportDistance(): float
    {
        return $this->maxImportDistance;
    }

    public function setMaxExportDistance($maxExportDistance): void
    {
        $this->maxExportDistance = $maxExportDistance;
    }

    public function getMaxExportDistance(): float
    {
        return $this->maxExportDistance;
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        if (!$this->authKey) {
            return '';
        }

        return $this->authKey;
    }

    /**
     * @param string $authKey
     */
    public function setAuthKey(string $authKey): void
    {
        $this->authKey = $authKey;
    }

    /**
     * @return string
     */
    public function getAuthSecret(): string
    {
        if (!$this->authSecret) {
            return '';
        }

        return $this->authSecret;
    }

    /**
     * @param string $authSecret
     */
    public function setAuthSecret(string $authSecret): void
    {
        $this->authSecret = $authSecret;
    }

    /**
     * @return string
     */
    public function getAuthUsername(): string
    {
        if (!$this->authUsername) {
            return '';
        }

        return $this->authUsername;
    }
    /**
     * @param string $authUsername
     */
    public function setAuthUsername(string $authUsername): void
    {
        $this->authUsername = $authUsername;
    }

    /**
     * @return string
     */
    public function getAuthPassword(): string
    {
        if (!$this->authPassword) {
            return '';
        }

        return $this->authPassword;
    }

    /**
     * @param string $authPasword
     */
    public function setAuthPassword(string $authPasword): void
    {
        $this->authPassword = $authPasword;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        if (!$this->accountNumber) {
            return '';
        }

        return $this->accountNumber;
    }

    /**
     * @param string $accountNumber
     */
    public function setAccountNumber(string $accountNumber): void
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @param string $accountCode
     */
    public function setAccountCode(string $accountCode): void
    {
        $this->accountCode = $accountCode;
    }

    /**
     * @param string $accountCode
     */
    public function getAccountCode(): string
    {
        return $this->accountCode;
    }

    public function setDepotNumber(string $depotNumber)
    {
        $this->depotNumber = $depotNumber;
    }

    public function getDepotNumber(): string
    {
        if (!$this->depotNumber) {
            return '';
        }

        return $this->depotNumber;
    }

    /**
     * @return string
     */
    public function getMeterNumber(): string
    {
        if (!$this->meterNumber) {
            return '';
        }

        return $this->meterNumber;
    }

    /**
     * @param string $meterNumber
     */
    public function setMeterNumber(string $meterNumber): void
    {
        $this->meterNumber = $meterNumber;
    }

    /**
     * @param ShipmentColli $shipmentColli
     */
    public function addColli(ShipmentColli $shipmentColli)
    {
        $shipmentColli->setSequenceNumber((count($this->getShipmentCollies())) + 1);

        $this->shipmentCollies[] = $shipmentColli;
    }

    /**
     * @return bool
     */
    public function getShipmentIsCustomDuty(): bool
    {
        if (!$this->shipmentIsCustomDuty) {
            return 0;
        }

        return $this->shipmentIsCustomDuty;
    }

    /**
     * @param bool $shipmentIsCustomDuty
     */
    public function setShipmentIsCustomDuty(bool $shipmentIsCustomDuty): void
    {
        $this->shipmentIsCustomDuty = $shipmentIsCustomDuty;
    }

    /**
     * @return string
     */
    public function getShipmentDocumentContent(): string
    {
        if (!$this->shipmentDocumentContent) {
            return '';
        }

        return $this->shipmentDocumentContent;
    }

    /**
     * @param string $shipmentDocumentContent
     */
    public function setShipmentDocumentContent(string $shipmentDocumentContent): void
    {
        $this->shipmentDocumentContent = $shipmentDocumentContent;
    }

    /**
     * @return float
     */
    public function getShipmentCustomValueAmount(): float
    {
        if (!$this->shipmentCustomValueAmount) {
            return 0;
        }

        return $this->shipmentCustomValueAmount;
    }

    /**
     * @param float $shipmentCustomValueAmount
     */
    public function setShipmentCustomValueAmount(float $shipmentCustomValueAmount): void
    {
        $this->shipmentCustomValueAmount = $shipmentCustomValueAmount;
    }

    /**
     * @return string
     */
    public function getShipmentDescription(): string
    {
        if (!$this->shipmentDescription) {
            return '';
        }

        return $this->shipmentDescription;
    }

    /**
     * @param string $shipmentDescription
     */
    public function setShipmentDescription(string $shipmentDescription): void
    {
        $this->shipmentDescription = $shipmentDescription;
    }

    /**
     * @return string
     */
    public function getShipmentService(): string
    {
        if (!$this->shipmentService) {
            return '';
        }

        return $this->shipmentService;
    }

    /**
     * @param string $shipmentService
     */
    public function setShipmentService(string $shipmentService): void
    {
        $this->shipmentService = $shipmentService;
    }

    /**
     * @return string
     */
    public function getShipmentType()
    {

        $collis = $this->getShipmentCollies();
        if (count($collis) > 1) {

            foreach ($collis as $colli) {

                if ($colli->type == 'document') {
                    return 'package';
                } else if ($colli->type == 'pallet') {
                    return 'pallet';
                }
            }
        } else {

            return end($collis)->type;
        }

        return '';
    }

    /**
     * @param string $shipmentType
     */
    public function setShipmentType(string $shipmentType): void
    {
        $this->shipmentType = $shipmentType;
    }

    /**
     * @return string
     */
    public function getShipmentTracking(): string
    {
        return $this->shipmentTracking ?? '';
    }

    /**
     * @param string $shipmentTracking
     */
    public function setShipmentTracking(string $shipmentTracking): void
    {
        $this->shipmentTracking = $shipmentTracking;
    }

    /**
     * @return string
     */
    public function getShipmentPickupTimeStart(): string
    {

        ## If its DHL
        if ($this->getShipmentPickupOption() == 'existing') {
            return date('H:i', strtotime('+10min'));
        }

        if (!$this->shipmentPickupTimeStart) {
            return '';
        }

        return $this->shipmentPickupTimeStart;
    }

    /**
     * @param string $shipmentPickupTimeStart
     */
    public function setShipmentPickupTimeStart(string $shipmentPickupTimeStart): void
    {
        $this->shipmentPickupTimeStart = $shipmentPickupTimeStart;
    }

    /**
     * @return string
     */
    public function getShipmentPickupTimeUntil(): string
    {
        if (!$this->shipmentPickupTimeUntil) {
            return '';
        }

        return $this->shipmentPickupTimeUntil;
    }

    /**
     * @param string $shipmentPickupTimeUntil
     */
    public function setShipmentPickupTimeUntil(string $shipmentPickupTimeUntil): void
    {
        $this->shipmentPickupTimeUntil = $shipmentPickupTimeUntil;
    }

    /**
     * @return string
     */
    public function getShipmentPickupDate(): string
    {
        if (!$this->shipmentPickupDate) {
            return '';
        }

        return $this->shipmentPickupDate;
    }

    /**
     * @param string $shipmentPickupDate
     */
    public function setShipmentPickupDate(string $shipmentPickupDate): void
    {
        $this->shipmentPickupDate = $shipmentPickupDate;
    }

    /**
     * @return ShipmentColli
     */
    public function getShipmentColli(): ShipmentColli
    {
        return $this->shipmentColli;
    }

    /**
     * @param ShipmentColli $shipmentColli
     */
    public function setShipmentColli(ShipmentColli $shipmentColli): void
    {
        $this->shipmentColli = $shipmentColli;
    }

    /**
     * @return string
     */
    public function getShipmentPickupInstructions(): string
    {
        if (!$this->shipmentPickupInstructions) {
            return '';
        }

        return $this->shipmentPickupInstructions;
    }

    /**
     * @param string $shipmentPickupInstructions
     */
    public function setShipmentPickupInstructions(string $shipmentPickupInstructions): void
    {
        $this->shipmentPickupInstructions = $shipmentPickupInstructions;
    }

    /**
     * @return string
     */
    public function getShipmentPickupOption(): string
    {
        if (!$this->shipmentPickupOption) {
            return '';
        }

        return $this->shipmentPickupOption;
    }

    /**
     * @param string $shipmentPickupOption
     */
    public function setShipmentPickupOption(string $shipmentPickupOption): void
    {
        $this->shipmentPickupOption = $shipmentPickupOption;
    }

    /**
     * @return string
     */
    public function getShipmentPickupLocation(): string
    {
        if (!$this->shipmentPickupLocation) {
            return '';
        }

        return $this->shipmentPickupLocation;
    }

    /**
     * @param string $shipmentPickupLocation
     */
    public function setShipmentPickupLocation(string $shipmentPickupLocation): void
    {
        $this->shipmentPickupLocation = $shipmentPickupLocation;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels ?? [];
    }

    /**
     * @param array $label
     */
    public function addLabel(array $label): void
    {
        $this->labels[] = $label;
    }

    /**
     * @return float
     */
    public function getDimensionLengthLimit(): float
    {
        if (!$this->dimensionLengthLimit) {
            return 0;
        }

        return $this->dimensionLengthLimit;
    }

    /**
     * @param float $dimensionLengthLimit
     */
    public function setDimensionLengthLimit(float $dimensionLengthLimit): void
    {
        $this->dimensionLengthLimit = $dimensionLengthLimit;
    }

    /**
     * @return float
     */
    public function getDimensionWidthLimit(): float
    {
        if (!$this->dimensionWidthLimit) {
            return 0;
        }

        return $this->dimensionWidthLimit;
    }

    /**
     * @param float $dimensionWidthLimit
     */
    public function setDimensionWidthLimit(float $dimensionWidthLimit): void
    {
        $this->dimensionWidthLimit = $dimensionWidthLimit;
    }

    /**
     * @return float
     */
    public function getDimensionHeightLimit(): float
    {
        if (!$this->dimensionHeightLimit) {
            return 0;
        }

        return $this->dimensionHeightLimit;
    }

    /**
     * @param float $dimensionHeightLimit
     */
    public function setDimensionHeightLimit(float $dimensionHeightLimit): void
    {
        $this->dimensionHeightLimit = $dimensionHeightLimit;
    }

    /**
     * @return float
     */
    public function getDimensionWeightLimit(): float
    {
        if (!$this->dimensionWeightLimit) {
            return 0;
        }

        return $this->dimensionWeightLimit;
    }

    /**
     * @return float
     */
    public function getTailgateWeightLimit(): float
    {
        if (!$this->tailgateWeightLimit) {
            return 0;
        }

        return $this->tailgateWeightLimit;
    }

    /**
     * @param float $tailgateWeightLimit
     */
    public function setTailgateWeightLimit(float $tailgateWeightLimit): void
    {
        $this->tailgateWeightLimit = $tailgateWeightLimit;
    }

    /**
     * @return float
     */
    public function getTotalDistance(): float
    {
        if (!$this->totalDistance) {
            return 0;
        }

        return $this->totalDistance;
    }

    /**
     * @return float
     */
    public function getTotalDuration(): float
    {
        if (!$this->totalDuration) {
            return 0;
        }

        return $this->totalDuration;
    }

    /**
     * @param float $dimensionWeightLimit
     */
    public function setDimensionWeightLimit(float $dimensionWeightLimit): void
    {
        $this->dimensionWeightLimit = $dimensionWeightLimit;
    }

    /**
     * @return float
     */
    public function getDimensionVolumeLimit(): float
    {
        if (!$this->dimensionVolumeLimit) {
            return 0;
        }

        return $this->dimensionVolumeLimit;
    }

    /**
     * @param float $dimensionVolumeLimit
     */
    public function setDimensionVolumeLimit(float $dimensionVolumeLimit): void
    {
        $this->dimensionVolumeLimit = $dimensionVolumeLimit;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        if (!$this->rate) {
            return 0;
        }

        return $this->rate;
    }

    /**
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getInvoiceBase64File(): string
    {
        if (!$this->invoiceBase64File) {
            return '';
        }

        return $this->invoiceBase64File;
    }

    /**
     * @param string $invoiceBase64File
     */
    public function setInvoiceBase64File(string $invoiceBase64File): void
    {
        $this->invoiceBase64File = $invoiceBase64File;
    }

    /**
     * @return string
     */
    public function getInvoiceFileName(): string
    {
        if (!$this->invoiceFileName) {
            return '';
        }

        return $this->invoiceFileName;
    }

    /**
     * @param string $invoiceFileName
     */
    public function setInvoiceFileName(string $invoiceFileName): void
    {
        $this->invoiceFileName = $invoiceFileName;
    }

    /**
     * @return string
     */
    public function getInvoiceReference(): string
    {
        if (!$this->invoiceReference) {
            return '';
        }

        return $this->invoiceReference;
    }

    /**
     * @param string $invoiceReference
     */
    public function setInvoiceReference(string $invoiceReference): void
    {
        $this->invoiceReference = $invoiceReference;
    }

    /**
     * @return string
     */
    public function getInvoiceOriginCountryCode(): string
    {
        if (!$this->invoiceOriginCountryCode) {
            return '';
        }

        return $this->invoiceOriginCountryCode;
    }

    /**
     * @param string $invoiceOriginCountryCode
     */
    public function setInvoiceOriginCountryCode(string $invoiceOriginCountryCode): void
    {
        $this->invoiceOriginCountryCode = $invoiceOriginCountryCode;
    }

    /**
     * @return string
     */
    public function getInvoiceDestinationCountryCode(): string
    {
        if (!$this->invoiceDestinationCountryCode) {
            return '';
        }

        return $this->invoiceDestinationCountryCode;
    }

    /**
     * @param string $invoiceDestinationCountryCode
     */
    public function setInvoiceDestinationCountryCode(string $invoiceDestinationCountryCode): void
    {
        $this->invoiceDestinationCountryCode = $invoiceDestinationCountryCode;
    }

    /**
     * @return string
     */
    public function getLabelTemplate(): string
    {
        if (!$this->labelTemplate) {
            return '';
        }

        return $this->labelTemplate;
    }

    /**
     * @param string $labelTemplate
     */
    public function setLabelTemplate(string $labelTemplate): void
    {
        $this->labelTemplate = $labelTemplate;
    }

    /**
     * @return string
     */
    public function getServiceCollectionCode(): string
    {
        if (!$this->serviceCollectionCode) {
            return '';
        }

        return $this->serviceCollectionCode;
    }

    /**
     * @param string $serviceCollectionCode
     */
    public function setServiceCollectionCode(string $serviceCollectionCode): void
    {
        $this->serviceCollectionCode = $serviceCollectionCode;
    }

    /**
     * @return string
     */
    public function getServiceCollectionSurcharge(): string
    {
        if (!$this->serviceCollectionSurcharge) {
            return '';
        }

        return $this->serviceCollectionSurcharge;
    }

    /**
     * @param string $serviceCollectionSurcharge
     */
    public function setServiceCollectionSurcharge(string $serviceCollectionSurcharge): void
    {
        $this->serviceCollectionSurcharge = $serviceCollectionSurcharge;
    }

    /**
     * @return string
     */
    public function getServiceDeliveryCode(): string
    {
        if (!$this->serviceDeliveryCode) {
            return '';
        }

        return $this->serviceDeliveryCode;
    }

    /**
     * @param string $serviceDeliveryCode
     */
    public function setServiceDeliveryCode(string $serviceDeliveryCode): void
    {
        $this->serviceDeliveryCode = $serviceDeliveryCode;
    }

    /**
     * @return string
     */
    public function getServiceDeliverySurcharge(): string
    {
        if (!$this->serviceDeliverySurcharge) {
            return '';
        }

        return $this->serviceDeliverySurcharge;
    }

    /**
     * @param string $serviceDeliverySurcharge
     */
    public function setServiceDeliverySurcharge(string $serviceDeliverySurcharge): void
    {
        $this->serviceDeliverySurcharge = $serviceDeliverySurcharge;
    }

    /**
     * @return string
     */
    public function getLifts(): string
    {
        if (!$this->lifts) {
            return 1;
        }

        return $this->lifts;
    }

    /**
     * @param string $lifts
     */
    public function setLifts(string $lifts): void
    {
        $this->lifts = $lifts;
    }


    /**
     * @return bool
     */
    public function getExw()
    {
        return $this->exw ?? false;
    }

    /**
     * @param $exw
     */
    public function setExw($exw)
    {
        $this->exw = $exw;
    }

    /**
     * @return string
     */
    public function getExwAccount()
    {
        return $this->exw_account ?? '';
    }

    /**
     * @param $account
     */
    public function setExwAccount($account)
    {
        $this->exw_account = $account;
    }

    /**
     * @return ShipmentContactAddress
     */
    public function getShipmentExwAddress(): ShipmentContactAddress
    {
        if (!$this->shipmentExwAddress) {
            return new ShipmentContactAddress();
        }

        return $this->shipmentExwAddress;
    }

    /**
     * @param ShipmentContactAddress $shipmentExwAddress
     */
    public function setShipmentExwAddress(ShipmentContactAddress $shipmentExwAddress): void
    {
        $this->shipmentExwAddress = $shipmentExwAddress;
    }
}
