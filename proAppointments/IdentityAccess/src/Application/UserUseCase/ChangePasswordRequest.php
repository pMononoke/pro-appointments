<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ServiceRequest;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class ChangePasswordRequest implements ServiceRequest
{
    /** @var UserId */
    private $userId;

    /** @var string */
    private $plainPassword;

    /**
     * RegisterUserRequest constructor.
     */
    public function __construct(UserId $userId, string $plainPassword)
    {
        $this->userId = $userId;
        $this->plainPassword = $plainPassword;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function plainPassword(): string
    {
        return $this->plainPassword;
    }
}
