<?php
namespace Dx;

use Dx\Exceptions\InvalidSessionKey;
use Dx\Models\Address;
use Dx\Models\Consignment;
use Dx\Exceptions\BadRequest;
use Dx\Exceptions\InvalidConsignment;


use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationTest
 * @package Dx
 * @covers \Dx\Application
 */
class ApplicationTest extends TestCase
{
    private Application $_application;

    private Consignment $_consignment;


    public function setUp(): void
    {
        $this->_application = new Application('93019994', '99', '955698');
        $this->_consignment = new Consignment($this->_application);
    }

    /**
     * @return Consignment
     * @throws \DX\Exceptions\InvalidFieldLength
     */
    private function createMockConsignment():Consignment{

        $consignment = new Consignment($this->_application);

        $consignment->setConsignmentReference('Alexandr')
            ->setServiceCode(Consignment::SERVICE_OVERNIGHT);

        $address = new Address($this->_application);

        $address
            ->setCompanyName('Matic Media')
            ->setAddressLine1('9 Hagmill Road')
            ->setAddressLine2('Coatbridge')
            ->setPostcode('ML5 4XD')
            ->setContactName('Alexandr')
            ->setPhoneNumber('07725197080');

        $consignment->setCollectionAddress($address);
        $consignment->setDeliveryAddress($address);
        $consignment->setManifestDate(new \DateTime());

        return $consignment;
    }


    /**
     * @testCase is consignment exists
     */
    public function testSetInvalidConsignmentReference(): void {
        $this->expectException(InvalidConsignment::class);
        $this->_application->trackConsignment($this->_consignment->setConsignmentReference('7J89789788789'));
    }

    /**
     * @testCase set Invalid login
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testInvalidLoginApplication(): void {

        $this->expectException(InvalidSessionKey::class);
        $testApp = new Application('wrongLogin', 'Pass', 'andServiceCenter');
        $testApp->getSessionKey();
    }

    /**
     * @testCase Create a consignment with an invalid date
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws Exceptions\InvalidFieldLength
     */
    public function testCreateAmendConsignmentInvalidDate(): void {

        $this->expectException(BadRequest::class);

        $date = new \DateTime();
        $date->modify('-1 day');
        $consignment = $this->createMockConsignment();
        $consignment->setConsignmentNumber('L2987877');
        $consignment->setManifestDate($date);
        $this->_application->createConsignment($consignment);
    }

}