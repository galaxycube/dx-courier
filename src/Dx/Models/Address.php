<?php


namespace Dx\Models;


use Dx\Exceptions\InvalidFieldLength;

/**
 * Class Address
 * Represents the address to use with a consignment
 *
 * @package Dx\Models
 */
class Address
{
    private string $_companyName;
    private string $_addressLine1;
    private string $_addressLine2;
    private string $_addressLine3;
    private string $_addressLine4;
    private string $_addressLine5;
    private string $_postcode;
    private string $_phoneNumber;
    private string $_email;
    private string $_contactName;
    private bool $_residentialAddress = false;

    /**
     * Checks if a field has the correct length
     *
     * @param string $fieldName
     * @param string $fieldValue
     * @param int $maxLength
     * @throws InvalidFieldLength
     */
    public function checkLength(string $fieldName,string $fieldValue,int $maxLength): void {
        $length = strlen($fieldValue);
        if($length > $maxLength || $length < 1) {
            throw new InvalidFieldLength($fieldName, $length, $maxLength);
        }
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->_companyName;
    }

    /**
     * @param string $companyName
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setCompanyName(string $companyName): Address
    {
        $this->checkLength('Company Name', $companyName, 25);
        $this->_companyName = $companyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressLine1(): string
    {
        return $this->_addressLine1;
    }

    /**
     * @param string $addressLine1
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setAddressLine1(string $addressLine1): Address
    {
        $this->checkLength('Address Line 1', $addressLine1, 25);

        $this->_addressLine1 = $addressLine1;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressLine2(): string
    {
        return !empty($this->_addressLine2) ? $this->_addressLine2 : '';
    }

    /**
     * @param string $addressLine2
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setAddressLine2(string $addressLine2): Address
    {
        $this->checkLength('Address Line 2', $addressLine2, 30);
        $this->_addressLine2 = $addressLine2;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressLine3(): string
    {
        return !empty($this->_addressLine3) ? $this->_addressLine3 : '';
    }

    /**
     * @param string $addressLine3
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setAddressLine3(string $addressLine3): Address
    {
        $this->checkLength('Address Line 3', $addressLine3, 30);
        $this->_addressLine3 = $addressLine3;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressLine4(): string
    {
        return !empty($this->_addressLine4) ? $this->_addressLine4 : '';
    }

    /**
     * @param string $addressLine4
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setAddressLine4(string $addressLine4): Address
    {
        $this->checkLength('Address Line 4', $addressLine4, 30);
        $this->_addressLine4 = $addressLine4;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddressLine5(): string
    {
        return !empty($this->_addressLine5) ? $this->_addressLine5 : '';
    }

    /**
     * @param string $addressLine5
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setAddressLine5(string $addressLine5): Address
    {
        $this->checkLength('Address Line 5', $addressLine5, 30);
        $this->_addressLine5 = $addressLine5;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->_postcode;
    }

    /**
     * @param string $postcode
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setPostcode(string $postcode): Address
    {
        $this->checkLength('Postcode', $postcode, 8);
        $this->_postcode = $postcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->_phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setPhoneNumber(string $phoneNumber): Address
    {
        $this->checkLength('Phone Number', $phoneNumber, 14);
        $this->_phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return !empty($this->_email) ? $this->_email : '';
    }

    /**
     * @param string $email
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setEmail(string $email): Address
    {
        $this->checkLength('Email', $email, 100);
        $this->_email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getContactName(): string
    {
        return $this->_contactName;
    }

    /**
     * @param string $contactName
     * @return Address
     * @throws InvalidFieldLength
     */
    public function setContactName(string $contactName): Address
    {
        $this->checkLength('Contact Name', $contactName, 20);
        $this->_contactName = $contactName;
        return $this;
    }

    /**
     * @return bool
     */
    public function isResidentialAddress(): bool
    {
        return $this->_residentialAddress;
    }

    /**
     * @param bool $residentialAddress
     * @return Address
     */
    public function setResidentialAddress(bool $residentialAddress): Address
    {
        $this->_residentialAddress = $residentialAddress;
        return $this;
    }

    /**
     * Checks if the address is valid
     *
     * @return bool
     */
    public function isValid(): bool {
        //check required fields are all seated up
        if(empty($this->_companyName) ||
            empty($this->_addressLine1) ||
            empty($this->_postcode) ||
            empty($this->_phoneNumber) ||
            empty($this->_contactName)) {
            return false;
        }
        return true; // all fields set return true
    }
}