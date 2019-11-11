<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Notification;

use DateTimeImmutable;

class DummyEvent
{
    private const EVENT_NAME = '';

    private $userId;

    private $email;

    /** @var \DateTimeImmutable */
    private $occurredOn;

    public function __construct(string $userId, string $email)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function toPayload(): array
    {
        return [
            'userId' => $this->userId,
            'email' => $this->email,
        ];
    }
}
