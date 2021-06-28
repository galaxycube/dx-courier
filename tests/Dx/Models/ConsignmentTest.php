<?php


namespace Dx\Models;

use Dx\Application;
use Dx\Models\Address;
use Dx\Models\Consignment;
use Dx\Models\Consignment\Label;


use PHPUnit\Framework\TestCase;

/**
 * Class ConsignmentTest
 * @package Dx\Models
 * @covers \Dx\Models\Consignment
 */
class ConsignmentTest extends TestCase
{
    private Consignment $_consignment;
    private Application $_application;

    private $_mock;

    public function setUp(): void
    {
        $this->_application = new Application(93019994, 99, 955698);

        $this->_consignment = new Consignment($this->_application);
    }

    /**
     * @testCase Set service code
     */
    public function testServiceCode(): void
    {
        $this->_consignment->setServiceCode(Consignment::SERVICE_OVERNIGHT);
        self::assertEquals(Consignment::SERVICE_OVERNIGHT, $this->_consignment->getServiceCode());
    }

    /**
     * @testCase Set Routing Stream
     */
    public function testRoutingStream(): void
    {
        $this->_consignment->setRoutingStream('Routing Stream');
        self::assertEquals('Routing Stream', $this->_consignment->getRoutingStream());
    }

    /**
     * testCase check: is getCollectionAddress belongs to Address collection
     */
    public function testCollectionAddress(): void
    {
        $this->_consignment->setCollectionAddress(new Address());
        $this->assertInstanceOf(Address::class, $this->_consignment->getCollectionAddress(), ' must be an instance of Address'); // .print_r($mock)
    }

    /**
     * testCase check: is getLabel belongs to Label collection
     */
    public function testGetLabel()
    {
        $mock = $this->getMockBuilder(Consignment::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $mock->method('getLabels');

        $this->assertTrue(is_a($mock->getLabels(), Label::class), ' >>>> ');
    }

    /**
     * testCase check: getCollectionAddress belongs to Address collection
     */
    public function testCollectionAddressReturnFalse(){
        $this->assertFalse($this->_consignment->getCollectionAddress(), 'Consignment should be returning false');
    }


    /**
     * @testCase Set Consignment Reference
     */
    public function testConsignmentReference(): void {

        $this->_consignment->setConsignmentReference('L123456789');
        self::assertEquals('L123456789', $this->_consignment->getConsignmentReference());
    }

    /**
     * @testCase Set BookInFlag
     */
    public function testBookInFlag(): void {

        $this->_consignment->setBookInFlag(true);
        self::assertEquals(true, $this->_consignment->isBookInFlag());
    }

    /**
     * @testCase Set Insurance Value
     */
    public function testInsuranceValue(): void {

        $this->_consignment->setInsuranceValue(500);
        self::assertEquals(500, $this->_consignment->getInsuranceValue());
    }

    /**
     * @testCase Set Special Instructions
     */
    public function testSpecialInstructions(): void {

        $this->_consignment->setSpecialInstructions('Special Instructions');
        self::assertEquals('Special Instructions', $this->_consignment->getSpecialInstructions());
    }

}