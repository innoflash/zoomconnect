<?php

namespace Innoflash\Zoomconnect\Models;

class MessageResponse
{
    private $messageId;
    private $message;
    private $recipientNumber;

    public function getMessageId(): string
    {
        return $this->messageId;
    }
    public function getMessage(): string
    {
        return $this->message;
    }
    public function getRecipientNumber(): string
    {
        return $this->recipientNumber;
    }

    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setRecipientNumber($recipientNumber)
    {
        $this->recipientNumber = $recipientNumber;
    }
}
