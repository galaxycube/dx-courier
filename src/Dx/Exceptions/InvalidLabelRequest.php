<?php
namespace Dx\Exceptions;

class InvalidLabelRequest extends \Exception
{
    /**
     * InvalidLabelRequest constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}