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

    public function addInfo(string $message, null|string $field = null): static
    {
        return $this->addMessage(Message::info($message, $field));
    }

    public function addSuccess(string $message, null|string $field = null): static
    {
        return $this->addMessage(Message::success($message, $field));
    }

    public function addWarning(string $message, null|string $field = null): static
    {
        return $this->addMessage(Message::warning($message, $field));
    }

    public function addDanger(string $message, null|string $field = null): static
    {
        return $this->addMessage(Message::danger($message, $field));
    }

    public function addMessage(Message $message): static
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
