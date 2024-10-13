<?php declare(strict_types=1);

namespace Leaditin\Communication\Notification;

use InvalidArgumentException;

/**
 * @package Leaditin\Communication
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class Manager
{
    /** @var Message[][] */
    protected array $messages = [];

    public function createMessage(string $message, string $type, null|string $field = null): Message
    {
        $msg = match ($type) {
            Message::INFO => Message::info($message, $field),
            Message::SUCCESS => Message::success($message, $field),
            Message::WARNING => Message::warning($message, $field),
            Message::DANGER => Message::danger($message, $field),
            default => throw new InvalidArgumentException('Invalid message type'),
        };

        $this->appendMessage($msg);

        return $msg;
    }

    public function appendMessage(Message $message): Manager
    {
        $this->messages[$message->type][] = $message;

        return $this;
    }

    public function getMessages(string $type = null): array
    {
        if ($type === null) {
            $messages = [];
            foreach ($this->messages as $group) {
                $messages[] = $group;
            }

            if (count($messages)) {
                return array_merge(...$messages);
            }

            return [];
        }

        return $this->messages[$type] ?? [];
    }

    public function hasMessages(string $type): bool
    {
        return count($this->messages[$type] ?? []) > 0;
    }

    public function toArray(string $type = null): array
    {
        $array = [];

        foreach ($this->getMessages($type) as $message) {
            $array[] = $message->toArray();
        }

        return $array;
    }

    public function clear(): static
    {
        $this->messages = [];

        return $this;
    }
}
