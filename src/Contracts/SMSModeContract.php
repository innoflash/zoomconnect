<?php

namespace Innoflash\Zoomconnect\Contracts;

use Exception;
use GuzzleHttp\Client;
use Innoflash\Zoomconnect\Models\MessageResponse;
use Illuminate\Auth\Access\AuthorizationException;
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

    protected function getHeaders()
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
            'content' => (array) $this->getMessageData($this->getRecipient(), $this->getMessage())
        ]);

        // $ch = curl_init(ZoomConnectConfig::getSingleSMSUrl());
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getMessageData($this->getRecipient(), $this->getMessage()));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        // $result = curl_exec($ch);
        //   return $this->getMessageData($this->getRecipient(), $this->getMessage());
    }

    protected function processError(Exception $e)
    {
        if ($e->getCode() === 401) throw AuthorizationException('You are not authorized to use this service, invalid credentials');
        if ($e->getCode() === 403) throw AuthorizationException('You are not authorized to use this service, you are forbidden');
        else \abort(500, $e->getMessage());
    }

    protected function processOnSuccess($result): array
    {
        $result = json_encode($result, true);
        $result = (object) $result;

        $messageResponse = new MessageResponse;
        $messageResponse->setMessage($this->getMessage());
        $messageResponse->setRecipientNumber($this->getRecipient());
        $messageResponse->setMessageId($result->messageId);
        return (array) $messageResponse;
    }
}
