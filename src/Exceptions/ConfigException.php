<?php

namespace Innoflash\Zoomconnect\Exceptions;

use Exception;

class ConfigException extends Exception
{
    static function missingConfig(string $missingPart): self
    {
        return new static("$missingPart is missing in the config/zoomconnect.php or .ENV");
    }

    static function optionOutOfBounds(string $key, string $value, array $options): self
    {
        return new static("$value is not a valid input for $key, you should use one of [" . implode(', ', $options) . "]");
    }
}
