<?php

namespace Dx\Models;

use Dx\Models\Consignment\Log;

/**
 * Class Logs
 * @package Dx\Models
 * @method Log[] getIterator()
 */
class Logs extends \ArrayObject {

    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';

    /**
     * @param Log $log
     * @return $this
     */
    public function add(Log $log): self {
        $this->append($log);
        return $this;
    }

    /**
     * sorts Logs by date
     *
     * @return bool
     */
    public function sortByDate($flag =self::SORT_ASC): bool {
        if($flag === self::SORT_ASC) {
            return $this->uasort(function (Log $a, Log $b) { return ($a->getDateTime()->getTimestamp() <=> $b->getDateTime()->getTimestamp()); });
        }
        return $this->uasort(function (Log $a, Log $b) { return -($a->getDateTime()->getTimestamp() <=> $b->getDateTime()->getTimestamp()); });
    }
}