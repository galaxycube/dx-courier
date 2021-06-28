<?php
namespace Dx\Models;

use Dx\Application;
use Dx\Exceptions\InvalidConsignment;
use Dx\Models\Consignment\Label;
use Dx\Models\Consignment\Packages;

/**
 * Class Consignment
 * Represents a consignment
 *
 * @package Dx\Models
 */
class Consignment
{
    const SERVICE_OVERNIGHT = 'ON';
    const SERVICE_3DAY = '3D';
    const SERVICE_OVERNIGHT_930 = '930';
    const SERVICE_OVERNIGHT_PRE_NOON = 'AM';
    const SERVICE_SATURDAY = 'SAT';
    const SERVICE_SATURDAY_930 = 'S93';
    const SERVICE_2MAN_STANDARD = 'H2';
    const SERVICE_2MAN_OVERNIGHT = 'H1';
    const SERVICE_2MAN_SATURDAY = 'HS';
    const SERVICE_2MAN_COLLECTION_OVERNIGHT = 'C1';
    const SERVICE_2MAN_COLLECTION_STANDARD = 'C2';
    const SERVICE_2MAN_COLLECTION_SATURDAY = 'CS';

    private Application $_application;
    private \DateTime $_manifestDate;
    private string $_consignmentReference;
    private string $_serviceCode;
    private bool $_bookInFlag = false;
    private float $_insuranceValue = 0;
    private string $_specialInstructions = '';
    private Address $_deliveryAddress;
    private Address $_collectionAddress;
    private Packages $_packages;
    private string $_consignmentNumber;
    private string $_routingStream;
    private Label $_labels;

    /**
     * Consignment constructor.
     */
    public function __construct(Application $_application) {
        $this->_application = $_application;
        $this->_packages = new Packages();
        $this->_manifestDate = new \DateTime();
    }

    /**
     * @return Address|false
     */
    public function getCollectionAddress()
    {
        return empty($this->_collectionAddress) ? false : $this->_collectionAddress;
    }

    /**
     * @param Address $collectionAddress
     * @return Consignment
     */
    public function setCollectionAddress(Address $collectionAddress): Consignment
    {
        $this->_collectionAddress = $collectionAddress;
        return $this;
    }

    /**
     * @return Label
     */
    public function getLabels(): Label
    {
        if(empty($this->_labels)) {
            $this->_labels = $this->_application->getConsignmentLabel($this);
        }

        return $this->_labels;
    }

    /**
     * @param Label $labels
     * @return Consignment
     */
    public function setLabels(Label $labels): Consignment
    {
        $this->_labels = $labels;
        return $this;
    }

    /**
     * @return string|false
     */
    public function getRoutingStream()
    {
        if(empty($this->_routingStream)) {
            return false;
        }
        return $this->_routingStream;
    }

    /**
     * @param string $routingStream
     * @return Consignment
     */
    public function setRoutingStream(string $routingStream): Consignment
    {
        $this->_routingStream = $routingStream;
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceCode(): string
    {
        return $this->_serviceCode;
    }

    /**
     * @param string $serviceCode
     * @return Consignment
     */
    public function setServiceCode(string $serviceCode): Consignment
    {
        $this->_serviceCode = $serviceCode;
        return $this;
    }

    /**
     * @return string|false //returns false when the consignment number has not been set yet
     */
    public function getConsignmentNumber()
    {
        if(empty($this->_consignmentNumber)) {
            return false;
        }
        return $this->_consignmentNumber;
    }

    /**
     * @param string $consignmentNumber
     * @return Consignment
     */
    public function setConsignmentNumber(string $consignmentNumber): Consignment
    {
        $this->_consignmentNumber = $consignmentNumber;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getManifestDate(): \DateTime
    {
        return $this->_manifestDate;
    }

    /**
     * @param \DateTime $manifestDate
     * @return Consignment
     */
    public function setManifestDate(\DateTime $manifestDate): Consignment
    {
        $this->_manifestDate = $manifestDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getConsignmentReference(): string
    {
        return $this->_consignmentReference;
    }

    /**
     * @param string $consignmentReference
     * @return Consignment
     */
    public function setConsignmentReference(string $consignmentReference): Consignment
    {
        $this->_consignmentReference = $consignmentReference;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBookInFlag(): bool
    {
        return $this->_bookInFlag;
    }

    /**
     * @param bool $bookInFlag
     * @return Consignment
     */
    public function setBookInFlag(bool $bookInFlag): Consignment
    {
        $this->_bookInFlag = $bookInFlag;
        return $this;
    }

    /**
     * @return float
     */
    public function getInsuranceValue(): float
    {
        return $this->_insuranceValue;
    }

    /**
     * @param float $insuranceValue
     * @return Consignment
     */
    public function setInsuranceValue(float $insuranceValue): Consignment
    {
        $this->_insuranceValue = $insuranceValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getSpecialInstructions(): string
    {
        return $this->_specialInstructions;
    }

    /**
     * @param string $specialInstructions
     * @return Consignment
     */
    public function setSpecialInstructions(string $specialInstructions): Consignment
    {
        $this->_specialInstructions = $specialInstructions;
        return $this;
    }

    /**
     * @return Packages
     */
    public function getPackages(): Packages
    {
        return $this->_packages;
    }

    /**
     * @param Packages $packages
     * @return Consignment
     */
    public function setPackages(Packages $packages): Consignment
    {
        $this->_packages = $packages;
        return $this;
    }

    /**
     * @return Address
     */
    public function getDeliveryAddress(): Address
    {
        return $this->_deliveryAddress;
    }

    /**
     * @param Address $deliveryAddress
     * @return Consignment
     */
    public function setDeliveryAddress(Address $deliveryAddress): Consignment
    {
        $this->_deliveryAddress = $deliveryAddress;
        return $this;
    }

    /**
     * Saves the consignment
     * @throws InvalidConsignment
     */
    public function save(): self {
        $this->isValid();
        if($this->getConsignmentNumber()) {
            return $this->_application->updateConsignment($this);
        }
        return $this->_application->createConsignment($this);
    }

    /**
     * Calls the tracking mechanism
     * @throws InvalidConsignment
     */
    public function track(): self {
        return $this->_application->trackConsignment($this);
    }

    /**
     * @return bool
     */
    public function isValid(): bool {
        if(empty($this->_consignmentReference)) {
            throw new InvalidConsignment('Consignment Reference is required');
        }

        if(empty($this->_serviceCode)) {
            throw new InvalidConsignment('Service Code is required');
        }

        if(!$this->_packages->isValid()) {
            throw new InvalidConsignment('Invalid packages');
        }

        if(!$this->_deliveryAddress->isValid()) {
            throw new InvalidConsignment('Invalid delivery address');
        }

        return true;
    }
}