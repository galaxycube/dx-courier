<?php


namespace Dx\Exceptions;


class InvalidSessionKey extends \Exception
{
    /** The error message */
    protected $message = 'Invalid account or service center or password';
}