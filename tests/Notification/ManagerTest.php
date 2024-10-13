<?php declare(strict_types=1);

namespace Tests\Leaditin\Communication\Notification;

use Leaditin\Communication\Notification\Manager;
use Leaditin\Communication\Notification\Message;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @covers \Leaditin\Communication\Notification\Manager
 */
final class ManagerTest extends TestCase
{
    public function testCreateInfoMessageCorrectly(): void
    {
        $manager = new Manager();
        $message = $manager->createMessage('Information message', Message::INFO, 'field1');
        $this->assertEquals('info', $message->type);
        $this->assertEquals('Information message', $message->message);
        $this->assertEquals('field1', $message->field);
    }

    public function testCreateMessageWithInvalidTypeThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $manager = new Manager();
        $manager->createMessage('Invalid message', 'invalid_type');
    }

    public function testAppendMessageStoresMessageCorrectly(): void
    {
        $manager = new Manager();
        $message = Message::info('Information message', 'field1');
        $manager->appendMessage($message);
        $this->assertTrue($manager->hasMessages(Message::INFO));
    }

    public function testGetMessagesReturnsAllMessages(): void
    {
        $manager = new Manager();
        $message1 = Message::info('Information message', 'field1');
        $message2 = Message::success('Success message', 'field2');
        $manager->appendMessage($message1);
        $manager->appendMessage($message2);
        $messages = $manager->getMessages();
        $this->assertCount(2, $messages);
    }

    public function testGetMessagesByTypeReturnsCorrectMessages(): void
    {
        $manager = new Manager();
        $message1 = Message::info('Information message', 'field1');
        $message2 = Message::success('Success message', 'field2');
        $manager->appendMessage($message1);
        $manager->appendMessage($message2);
        $messages = $manager->getMessages(Message::INFO);
        $this->assertCount(1, $messages);
        $this->assertEquals('info', $messages[0]->type);
    }

    public function testToArrayReturnsCorrectArray(): void
    {
        $manager = new Manager();
        $message = Message::info('Information message', 'field1');
        $manager->appendMessage($message);
        $array = $manager->toArray();
        $expectedArray = [
            [
                'message' => 'Information message',
                'field' => 'field1',
                'type' => 'info',
            ],
        ];
        $this->assertEquals($expectedArray, $array);
    }

    public function testClearRemovesAllMessages(): void
    {
        $manager = new Manager();
        $message = Message::info('Information message', 'field1');
        $manager->appendMessage($message);
        $manager->clear();
        $this->assertFalse($manager->hasMessages(Message::INFO));
    }
}