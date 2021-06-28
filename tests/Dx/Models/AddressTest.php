<?php


namespace Dx\Models;

use Dx\Models\Address;
use Dx\Exceptions\InvalidFieldLength;

use PHPUnit\Framework\TestCase;

/**
 * Class AddressTest
 * @package Dx\Models
 * @covers \Dx\Models\Address
 */
class AddressTest extends TestCase
{

    private Address $_address;

    public function setUp(): void
    {
        $this->_address = new Address();
    }


    /**
     * @testCase Set company name
     */
    public function testCompanyName(): void {
        $this->_address->setCompanyName('Matic Media');
        self::assertEquals('Matic Media', $this->_address->getCompanyName());
    }


    /**
     * @testCase Set Address Line 1
     */
    public function testAddressLine1(): void {
        $this->_address->setAddressLine1('9 Hagmill Road');
        self::assertEquals('9 Hagmill Road', $this->_address->getAddressLine1());
    }

    /**
     * @testCase Exception: 'AddressLine1' InvalidFieldLength > 25
     *
     * @throws InvalidFieldLength
     */
    public function testException(): void {

        $this->expectException(InvalidFieldLength::class);
        $this->_address->setAddressLine1('9 Hagmill Road 9 Hagmill Road 9 Hagmill Road 9 Hagmill Road 9');
    }

    /**
     * @testCase Set Address Line 2
     */
    public function testAddressLine2(): void {
        $this->_address->setAddressLine2('East Shawhead Ind Est');
        self::assertEquals('East Shawhead Ind Est', $this->_address->getAddressLine2());
    }

    /**
     * @testCase Set Address Line 3
     */
    public function testAddressLine3(): void {
        $this->_address->setAddressLine3('Coatbridge');
        self::assertEquals('Coatbridge', $this->_address->getAddressLine3());
    }

    /**
     * @testCase Set Address Line 4
     */
    public function testAddressLine4(): void {
        $this->_address->setAddressLine4('North Lanarkshire');
        self::assertEquals('North Lanarkshire', $this->_address->getAddressLine4());
    }

    /**
     * @testCase Set Postcode
     */
    public function testPostcode(): void {
        $this->_address->setPostcode('ML5 4XD');
        self::assertEquals('ML5 4XD', $this->_address->getPostcode());
    }

    /**
     * @testCase Exception: 'Postcode' InvalidFieldLength > 8
     *
     * @throws InvalidFieldLength
     */
    public function testExceptionPostcode(): void {

        $this->expectException(InvalidFieldLength::class);
        $this->_address->setPostcode('ML5 4XD 4XD');
    }

    /**
     * @testCase Set phone number
     */
    public function testPhoneNumber(): void {
        $this->_address->setPhoneNumber('+4403303800172');
        self::assertEquals('+4403303800172', $this->_address->getPhoneNumber());
    }

    /**
     * @testCase Set contact name
     */
    public function testContactName(): void {
        $this->_address->setContactName('Robert McCombe');
        self::assertEquals('Robert McCombe', $this->_address->getContactName());
    }

    /**
     * @testCase Set email
     */
    public function testEmail(): void {
        $this->_address->setEmail('info@graphicwarehouse.co.uk');
        self::assertEquals('info@graphicwarehouse.co.uk', $this->_address->getEmail());
    }

    /**
     * @testCase Check, all important fields must be field.
     */
    public function testValidateFields(): void {
        $this->_address->setCompanyName('Matic Media')
        ->setAddressLine1('9 Hagmill Road')
        ->setPostcode('ML5 4XD')
        ->setPhoneNumber('+4403303800172')
        ->setContactName('Robert McCombe');

        self::assertEquals(true, $this->_address->isValid());
    }




}