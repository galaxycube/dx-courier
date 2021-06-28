<?php


namespace Dx\Models;

use Dx\Exceptions\InvalidPackageType;
use Dx\Exceptions\InvalidPackageQuantity;

class Package
{
    const TYPE_CARTONKG = 1;
    const TYPE_KILOS = 2;
    const TYPE_LENGTH = 3;
    const TYPE_LENGTHGREATERTHAN3METRES = 4;
    const TYPE_IDW = 5;
    const TYPE_PALLET = 6;
    const TYPE_NIGHTPAK = 7;
    const TYPE_DOCPAK = 8;
    const TYPE_CARTONCA = 9;
    const TYPE_EUROBAG = 10;

    private int $_packageType;
    private int $_quantity;
    private string $_contentDescription;
    private int $_totalWeight;
    private int $_width;
    private int $_height;
    private int $_length;

    /**
     * @return string
     */
    public function getContentDescription(): string
    {
        return $this->_contentDescription;
    }

    /**
     * @param string $contentDescription
     * @return Package
     */
    public function setContentDescription(string $contentDescription): Package
    {
        $this->_contentDescription = $contentDescription;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return !empty($this->_width) ? $this->_width : 0;
    }

    /**
     * @param int $width
     * @return Package
     */
    public function setWidth(int $width): Package
    {
        $this->_width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return !empty($this->_height) ? $this->_height : 0;
    }

    /**
     * @param int $height
     * @return Package
     */
    public function setHeight(int $height): Package
    {
        $this->_height = $height;
        return $this;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return !empty($this->_length) ? $this->_length : 0;
    }

    /**
     * @param int $length
     * @return Package
     */
    public function setLength(int $length): Package
    {
        $this->_length = $length;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalWeight(): int
    {
        return $this->_totalWeight;
    }

    /**
     * @param int $totalWeight
     */
    public function setTotalWeight(int $totalWeight): Package
    {
        $this->_totalWeight = $totalWeight;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->_quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): Package
    {
        if($quantity < 1) {
            throw new InvalidPackageQuantity();
        }

        $this->_quantity = $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getPackageType(): int
    {
        return $this->_packageType;
    }

    /**
     * @param int $packageType
     */
    public function setPackageType(int $packageType): Package
    {
        if($packageType < 1 || $packageType > 10) {
            throw new InvalidPackageType();
        }

        $this->_packageType = $packageType;

        return $this;
    }

    /**
     * checks if this package is valid
     */
    public function isValid(): bool {
        if(empty($this->_packageType) ||
            empty($this->_contentDescription) ||
            empty($this->_totalWeight) ||
            empty($this->_quantity)) {
            return false;
        }
        return true;
    }

}