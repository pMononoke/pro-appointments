<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\NullRepository;

use ProAppointments\IdentityAccess\Domain\User\Exception\UserNotFound;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserRepository as UserRepositoryPort;

class UserRepository implements UserRepositoryPort
{
    public function register(User $user): void
    {
        return;
    }

    public function ofId(UserId $userId): User
    {
        throw UserNotFound::withId($userId);
    }

    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }
}
