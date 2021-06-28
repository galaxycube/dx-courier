<?php


namespace Dx\Exceptions;


class InvalidLoginCredentials extends \Exception
{
    /** The error message */
    protected $message = 'Invalid account or service center or password';
}