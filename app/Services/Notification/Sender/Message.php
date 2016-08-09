<?php
namespace App\Services\Notification\Sender;

/**
 * Class Message
 * @package App\Services\Notification\Sender
 */
class Message
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $message;

    /**
     * Message constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
        $this->id = uniqid();
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}