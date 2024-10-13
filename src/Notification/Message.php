<?php declare(strict_types=1);

namespace Leaditin\Communication\Notification;

/**
 * @package Leaditin\Communication
 * @author Igor Vuckovic <igor@vuckovic.biz>
 */
class Message
{
    public const INFO = 'info';
    public const SUCCESS = 'success';
    public const WARNING = 'warning';
    public const DANGER = 'danger';

    private function __construct(
        public readonly string      $message,
        public readonly string      $type,
        public readonly null|string $field = null
    ) {
    }

    public static function info(string $message, string $field = null): static
    {
        return new static($message, self::INFO, $field);
    }

    public static function success(string $message, string $field = null): static
    {
        return new static($message, self::SUCCESS, $field);
    }

    public static function warning(string $message, string $field = null): static
    {
        return new static($message, self::WARNING, $field);
    }

    public static function danger(string $message, string $field = null): static
    {
        return new static($message, self::DANGER, $field);
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'field' => $this->field,
            'type' => $this->type,
        ];
    }

    public function __toString()
    {
        return sprintf('%s: %s', $this->type, $this->message);
    }
}
