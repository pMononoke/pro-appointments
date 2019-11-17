<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ServiceRequest;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\UserId;

class ChangeFirstNameRequest implements ServiceRequest
{
    /** @var UserId */
    private $userId;

    /** @var FirstName */
    private $firstName;

    /**
     * RegisterUserRequest constructor.
     */
    public function __construct(UserId $userId, FirstName $firstName)
    {
        $this->userId = $userId;
        $this->firstName = $firstName;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function firstName(): FirstName
    {
        return $this->firstName;
    }
}
