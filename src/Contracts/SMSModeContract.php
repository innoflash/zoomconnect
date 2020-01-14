<?php

namespace Innoflash\Zoomconnect\Contracts;

use GuzzleHttp\Client;
use Innoflash\Zoomconnect\Helpers\ZoomConnectConfig;
use Innoflash\Zoomconnect\Exceptions\MessageException;
use Innoflash\Zoomconnect\Exceptions\RecipientException;

abstract class SMSModeContract
{
    private $recipient;
    private $message;

    abstract function getContentType(): string;

    abstract function getMessageData(string $recipient, string $message);

    function setRecepient(string $recipient)
    {
        $this->recipient = $recipient;
    }

    function getRecipient(): string
    {
        if (!$this->recipient) throw RecipientException::invalidRecipient();
        return $this->recipient;
    }

    function setMessage(string $message)
    {
        $this->message = $message;
    }

    function getMessage(): string
    {
        if (!$this->message || !strlen($this->message)) throw MessageException::invalidMessage();
        return $this->message;
    }

    private function getHeaders()
    {
        return [
            'Content-Type' => 'application/' . ZoomConnectConfig::getSMSMethod(),
            'Authorization' => 'Basic ' . base64_encode(ZoomConnectConfig::getCredentials()),
            'Content-Length' => strlen($this->getMessageData($this->getRecipient(), $this->getMessage()))
        ];
    }

    function sendMessage()
    {
        $client = new Client([
            'headers' => $this->getHeaders(),
            'timeout'  => 5.0,
        ]);
        return $client->post(ZoomConnectConfig::getSingleSMSUrl(), [
            'json' => (array) $this->getMessageData($this->getRecipient(), $this->getMessage())
        ]);

        // $ch = curl_init(ZoomConnectConfig::getSingleSMSUrl());
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getMessageData($this->getRecipient(), $this->getMessage()));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        // $result = curl_exec($ch);
        //   return $this->getMessageData($this->getRecipient(), $this->getMessage());
    }
}
