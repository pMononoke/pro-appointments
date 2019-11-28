<?php

namespace ProAppointments\IdentityAccess\Domain\User\Event;

use ProAppointments\IdentityAccess\Domain\User\UserId;

class UserWasDeleted
{
    private const EVENT_NAME = '';

    private $userId;

    /** @var \DateTimeImmutable */
    private $occurredOn;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;

        $this->occurredOn = new \DateTimeImmutable();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function toPayload(): array
    {
        return [
            'userId' => $this->userId->toString(),
        ];
    }
}
