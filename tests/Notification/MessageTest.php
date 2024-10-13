<?php declare(strict_types=1);

namespace Tests\Leaditin\Communication\Notification;

use Leaditin\Communication\Notification\Message;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Leaditin\Communication\Notification\Message
 */
final class MessageTest extends TestCase
{
    public function testInfoMessageIsCreatedCorrectly(): void
    {
        $message = Message::info('Information message', 'field1');
        $this->assertEquals('info', $message->type);
        $this->assertEquals('Information message', $message->message);
        $this->assertEquals('field1', $message->field);
    }

    public function testSuccessMessageIsCreatedCorrectly(): void
    {
        $message = Message::success('Success message', 'field2');
        $this->assertEquals('success', $message->type);
        $this->assertEquals('Success message', $message->message);
        $this->assertEquals('field2', $message->field);
    }

    public function testWarningMessageIsCreatedCorrectly(): void
    {
        $message = Message::warning('Warning message', 'field3');
        $this->assertEquals('warning', $message->type);
        $this->assertEquals('Warning message', $message->message);
        $this->assertEquals('field3', $message->field);
    }

    public function testDangerMessageIsCreatedCorrectly(): void
    {
        $message = Message::danger('Danger message', 'field4');
        $this->assertEquals('danger', $message->type);
        $this->assertEquals('Danger message', $message->message);
        $this->assertEquals('field4', $message->field);
    }

    public function testMessageToArrayReturnsCorrectArray(): void
    {
        $message = Message::info('Information message', 'field1');
        $expectedArray = [
            'message' => 'Information message',
            'field' => 'field1',
            'type' => 'info',
        ];
        $this->assertEquals($expectedArray, $message->toArray());
    }

    public function testMessageToStringReturnsCorrectString(): void
    {
        $message = Message::info('Information message');
        $this->assertEquals('info: Information message', (string)$message);
    }

    public function testMessageFieldCanBeNull(): void
    {
        $message = Message::info('Information message');
        $this->assertNull($message->field);
    }
}
