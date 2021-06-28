<?php


namespace Dx\Models\Consignment;

use Dx\Exceptions\InvalidConsignment;
use Dx\Models\Package;

/**
 * Class Packages
 * @package Dx\Models\Consignment
 * @implements \IteratorAggregate<int, Package>
 */
class Packages extends \ArrayObject
{
    /**
     * Checks
     * @return bool
     */
    public function hasPackages():bool {
        return count($this) > 0;
    }

    /**
     * Adds a new package to the packages
     * @param Package $package
     * @return $this
     */
    public function add(Package $package): self {
        //check if the package already exists in the array
        if(!$this->exists($package)) {
            $this->append($package);
        }
        return $this;
    }

    /**
     * Checks if the current package exists
     * @param Package $package
     * @return false|int
     */
    private function exists(Package $package) {

        foreach($this as $i => $childPackage) {
            if($childPackage === $package) {
                return $i;
            }
        }
        return false;
    }

    /**
     * @param Package $package
     * @return bool
     */
    public function remove(Package $package): bool {
        if($index = $this->exists($package)) {
            $this->offsetUnset($index);
            return true;
        }
        return false;
    }

    /**
     * checks if the packages are valid
     */
    public function isValid(): bool {
        if(!$this->hasPackages()) { //check if there are any packages
            throw new InvalidConsignment('No Packages Set');
        }

        //loop through each package and check if it is valid or not
        foreach($this as $package) {
            if(!$package->isValid()) {
                return false;
            }
        }

        return true;
    }
}