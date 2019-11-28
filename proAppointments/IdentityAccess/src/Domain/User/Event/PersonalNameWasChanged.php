<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User\Event;

use DateTimeImmutable;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\LastName;
use ProAppointments\IdentityAccess\Domain\User\UserId;

class PersonalNameWasChanged
{
    private $userId;

    private $firstName;

    private $lastName;

    private $occurredOn;

    public function __construct(UserId $userId, FirstName $firstName, LastName $lastName)
    {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    public function lastName(): LastName
    {
        return $this->lastName;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function toPayload(): array
    {
        return [
            'userId' => $this->userId->toString(),
            'firstName' => $this->firstName->toString(),
            'lastName' => $this->lastName->toString(),
        ];
    }
}
