<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ServiceRequest;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class ChangeNameRequest implements ServiceRequest
{
    /** @var UserId */
    private $userId;

    /** @var FirstName */
    private $firstName;

    /** @var LastName */
    private $lastName;

    public function __construct(string $userId, string $firstName, string $lastName)
    {
        $this->userId = UserId::fromString($userId);
        $this->firstName = FirstName::fromString($firstName);
        $this->lastName = LastName::fromString($lastName);
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
}
