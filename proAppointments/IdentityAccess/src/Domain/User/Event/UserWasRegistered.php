<?php

namespace ProAppointments\IdentityAccess\Domain\User\Event;

use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

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
