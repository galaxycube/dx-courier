<?php
namespace Dx\Exceptions;

class BadRequest extends \Exception
{
    /**
     * InvalidFieldLength constructor.
     * @param string $field
     * @param int $requiredLength
     */
    public function __construct(int $statusCode, string $statusMessage)
    {
        parent::__construct("Invalid DX Api Response " . $statusCode. ":" . $statusMessage, 0);
    }
}