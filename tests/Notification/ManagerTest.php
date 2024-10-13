<?php declare(strict_types=1);

namespace Tests\Leaditin\Communication\Notification;

use Leaditin\Communication\Notification\Manager;
use Leaditin\Communication\Notification\Message;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Leaditin\Communication\Notification\Manager
 */
final class ManagerTest extends TestCase
{
    public function testAddMessageStoresMessageCorrectly(): void
    {
        $manager = new Manager();
        $message = Message::info('Information message', 'field1');
        $manager->addMessage($message);
        $this->assertTrue($manager->hasMessages(Message::INFO));
    }

    public function testGetMessagesReturnsAllMessages(): void
    {
        $manager = new Manager();
        $message1 = Message::info('Information message', 'field1');
        $message2 = Message::success('Success message', 'field2');
        $manager->addMessage($message1);
        $manager->addMessage($message2);
        $messages = $manager->getMessages();
        $this->assertCount(2, $messages);
    }

    public function testGetMessagesByTypeReturnsCorrectMessages(): void
    {
        $manager = new Manager();
        $message1 = Message::info('Information message', 'field1');
        $message2 = Message::success('Success message', 'field2');
        $manager->addMessage($message1);
        $manager->addMessage($message2);
        $messages = $manager->getMessages(Message::INFO);
        $this->assertCount(1, $messages);
        $this->assertEquals('info', $messages[0]->type);
    }

    public function testToArrayReturnsCorrectArray(): void
    {
        $manager = new Manager();
        $message = Message::info('Information message', 'field1');
        $manager->addMessage($message);
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
        $manager->addMessage($message);
        $manager->clear();
        $this->assertFalse($manager->hasMessages(Message::INFO));
    }

    public function testAddInfoMessageCorrectly(): void
    {
        $manager = new Manager();
        $manager->addInfo('Information message', 'field1');
        $this->assertTrue($manager->hasMessages(Message::INFO));
    }

    public function testAddSuccessMessageCorrectly(): void
    {
        $manager = new Manager();
        $manager->addSuccess('Success message', 'field2');
        $this->assertTrue($manager->hasMessages(Message::SUCCESS));
    }

    public function testAddWarningMessageCorrectly(): void
    {
        $manager = new Manager();
        $manager->addWarning('Warning message', 'field3');
        $this->assertTrue($manager->hasMessages(Message::WARNING));
    }

    public function testAddDangerMessageCorrectly(): void
    {
        $manager = new Manager();
        $manager->addDanger('Danger message', 'field4');
        $this->assertTrue($manager->hasMessages(Message::DANGER));
    }
}
