<?php

namespace Innoflash\Zoomconnect\Contracts;

abstract class SMSModeContract
{
    abstract function getContentType(): string;

    private function getHeaders()
    {
    }
}
