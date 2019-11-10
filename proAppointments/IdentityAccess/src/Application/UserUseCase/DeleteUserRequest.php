<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ServiceRequest;
use ProAppointments\IdentityAccess\Domain\User\UserId;

class DeleteUserRequest implements ServiceRequest
{
    /** @var UserId */
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }
}
