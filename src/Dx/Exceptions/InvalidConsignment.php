<?php
namespace Dx\Exceptions;

class InvalidConsignment extends \Exception
{
    /**
     * InvalidConsignment constructor.
     * @param string $errorMessage
     */
    public function __construct(string $errorMessage)
    {
        parent::__construct($errorMessage);
    }
}