<?php

namespace Innoflash\Zoomconnect\Exceptions;

use Exception;

class MessageException extends Exception
{
    static function invalidMessage(): self
    {
        return new static('You are trying to send an invalid message');
    }
}
