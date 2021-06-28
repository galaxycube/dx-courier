<?php

namespace Dx\Models;

//?? :/
use Dx\Models\Package;
use Dx\Exceptions\InvalidPackageQuantity;
use Dx\Exceptions\InvalidPackageType;
use PHPUnit\Framework\TestCase;

/**
 * Class PackageTest
 * @package Dx\Models
 * @covers \Dx\Models\Package
 */
class PackageTest extends TestCase
{
    private Package $_package;

    public function setUp(): void
    {
        $this->_package = new Package();
    }

    /**
     * @testCase Set package type
     */
    public function testSetType(): void {
        $this->_package->setPackageType(Package::TYPE_PALLET);
        self::assertEquals(Package::TYPE_PALLET, $this->_package->getPackageType());
    }

    /**
     * @testCase Set an invalid package type (negative or 0)
     */
    public function testSetInvalidPackageType(): void {

        $this->expectException(InvalidPackageType::class);
        $this->_package->setPackageType(0);
    }

    /**
     * @testCase Checks quantity correct
     */
    public function testSetValidQuantity(): void {
        $this->_package->setQuantity(100);
        self::assertEquals(100, $this->_package->getQuantity());
    }

    /**
     * @testCase Set an invalid package quantity (negative or 0)
     */
    public function testSetInvalidQuantity(): void {
        $this->expectException(InvalidPackageQuantity::class);
        $this->_package->setQuantity(-1);
    }

    /**
     * @testCase Set content description
     */
    public function testContentDescription(): void {
        $this->_package->setContentDescription('CONTENT');
        self::assertEquals('CONTENT', $this->_package->getContentDescription());
    }

    /**
     * @testCase Set width
     */
    public function testWidth(): void {
        $this->_package->setWidth(50);
        self::assertEquals(50, $this->_package->getWidth());
    }

    /**
     * @testCase Set height
     */
    public function testHeight(): void {
        $this->_package->setHeight(50);
        self::assertEquals(50, $this->_package->getHeight());
    }

    /**
     * @testCase Set Length
     */
    public function testLength(): void {
        $this->_package->setLength(100);
        self::assertEquals(100, $this->_package->getLength());
    }

    /**
     * @testCase Set Total Weight
     */
    public function testTotalWeight(): void {
        $this->_package->setTotalWeight(70);
        self::assertEquals(70, $this->_package->getTotalWeight());
    }

    /**
     * @testCase is Valid: true
     */
    public function testIsValid(): void {

        $this->_package->setPackageType(1);
        $this->_package->setContentDescription('Some content');
        $this->_package->setTotalWeight(15);
        $this->_package->setQuantity(3);

        self::assertEquals(true, $this->_package->isValid());
    }
}