<?php

namespace Innoflash\Zoomconnect\SMSModes;

use stdClass;
use Innoflash\Zoomconnect\Contracts\SMSModeContract;

class JSONMode extends SMSModeContract
{
    function getContentType(): string
    {
        return 'json';
    }

    function getMessageData(string $recipient, string $message): string
    {
        $data = new stdClass();
        $data->message = $message;
        $data->recipientNumber = $recipient;
        return json_encode($data);
    }
}
