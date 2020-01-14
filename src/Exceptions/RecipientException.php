<?php

namespace Innoflash\Zoomconnect\Exceptions;

use Exception;

class RecipientException extends Exception
{

    static function invalidRecipient(): self
    {
        return new static('SMS receipient is invalid');
    }
}
