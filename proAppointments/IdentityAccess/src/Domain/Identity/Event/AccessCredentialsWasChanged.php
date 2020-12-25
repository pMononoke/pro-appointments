<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity\Event;

use DateTimeImmutable;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;

class AccessCredentialsWasChanged
{
    private $userId;

    private $password;

    private $occurredOn;

    public function __construct(UserId $userId, UserPassword $password)
    {
        $this->userId = $userId;
        $this->password = $password;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function toPayload(): array
    {
        return [
            'userId' => $this->userId->toString(),
            'password' => $this->password->toString(),
        ];
    }
}
