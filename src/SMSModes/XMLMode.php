<?php

namespace Innoflash\Zoomconnect\SMSModes;

use SimpleXMLElement;
use Innoflash\Zoomconnect\Contracts\SMSModeContract;

class XMLMode extends SMSModeContract
{
    function getContentType(): string
    {
        return 'xml';
    }

    function getMessageData(string $recipient, string $message)
    {
        $xml = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"utf-8\" ?><sendSmsRequest></sendSmsRequest>");
        $xml->addChild('message', $message);
        $xml->addChild('recipientNumber', $recipient);

        return $xml->asXML();
    }
}
