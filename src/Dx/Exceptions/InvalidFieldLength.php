<?php
namespace Dx\Exceptions;

class InvalidFieldLength extends \Exception
{
    /**
     * InvalidFieldLength constructor.
     * @param string $field
     * @param int $actualLength
     * @param int $requiredLength
     */
    public function __construct(string $field, int $actualLength, int $requiredLength)
    {
        parent::__construct("Invalid field length for field " . $field . " must be less than " . $actualLength . ' actual length '  . $requiredLength, 0);
    }
}