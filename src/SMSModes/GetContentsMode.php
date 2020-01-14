<?php

namespace Innoflash\Zoomconnect\SMSModes;

use stdClass;
use Innoflash\Zoomconnect\Contracts\SMSModeContract;
use Innoflash\Zoomconnect\Helpers\ZoomConnectConfig;

class GetContentsMode extends SMSModeContract
{
    function getContentType(): string
    {
        return 'json';
    }

    function getMessageData(string $recipient, string $message)
    {
        $data = new stdClass();
        $data->message = $message;
        $data->recipientNumber = $recipient;
        return json_encode($data);
    }

    function sendMessage()
    {
        $data = $this->getMessageData($this->getRecipient(), $this->getMessage());
        try {
            $result = file_get_contents(ZoomConnectConfig::getSingleSMSUrl(), null, stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header'           => "Content-type: application/json\r\n" .
                        "Connection: close\r\n" .
                        "Content-length: " . strlen($data) . "\r\n" .
                        "Authorization: Basic " . base64_encode(ZoomConnectConfig::getCredentials()) . "\r\n",
                    'content'          => $data,
                ]
            ]));
            return $result;
            return $this->processOnSuccess($result);
        } catch (\Exception $e) {
            return $this->processError($e);
        }
    }
}
