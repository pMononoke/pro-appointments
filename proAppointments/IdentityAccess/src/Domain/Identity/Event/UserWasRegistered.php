<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity\Event;

use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;

class UserWasRegistered
{
    private const EVENT_NAME = '';

    private $userId;

    private $email;

    private $password;

    /** @var \DateTimeImmutable */
    private $occurredOn;

    public function __construct(UserId $userId, UserEmail $email, ?UserPassword $password = null)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
        $this->occurredOn = new \DateTimeImmutable();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    /**
     * @return UserPassword
     */
    public function password(): ?UserPassword
    {
        return $this->password;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function toPayload(): array
    {
        return [
            'userId' => $this->userId->toString(),
            'email' => $this->email->toString(),
        ];
    }
}
