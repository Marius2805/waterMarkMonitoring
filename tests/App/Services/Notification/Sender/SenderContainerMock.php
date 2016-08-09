<?php
namespace Tests\App\Services\Notification\Sender;

use App\Services\Notification\Sender\Message;
use App\Services\Notification\Sender\SenderContainer;

/**
 * Class SenderContainerMock
 * @package Tests\App\Services\Notification\Sender
 */
class SenderContainerMock extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Message[]
     */
    private $receivedMessages = [];

    /**
     * @return SenderContainer
     */
    public function getContainer() : SenderContainer
    {
        $container = $this->getMockBuilder(SenderContainer::class)->getMock();

        $container->method('broadcast')
            ->will(self::returnCallback([$this, 'broadcastCallback']));

        return $container;
    }

    /**
     * @param Message $message
     */
    public function broadcastCallback(Message $message)
    {
        $this->receivedMessages[$message->getId()] = $message;
    }

    /**
     * @return Message[]
     */
    public function getReceivedMessages(): array
    {
        return $this->receivedMessages;
    }
}