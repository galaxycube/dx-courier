<?php
namespace Dx\Exceptions;

use Throwable;

class InvalidFieldLength extends \Exception
{
    /**
     * InvalidFieldLength constructor.
     * @param string $field
     * @param int $requiredLength
     */
    public function __construct(string $field, int $requiredLength, int $actualLength)
    {
        parent::__construct("Invalid field length for field " . $field . " must be less than " . $requiredLength . ' actual length '  . $actualLength, 0);
    }
}