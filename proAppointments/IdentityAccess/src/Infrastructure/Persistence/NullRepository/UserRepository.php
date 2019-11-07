<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\NullRepository;

use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserRepository as UserRepositoryPort;

class UserRepository implements UserRepositoryPort
{
    public function register(User $user): void
    {
    }

    public function ofId(UserId $userId): User
    {
    }

    public function nextIdentity(): UserId
    {
    }

    public function remove(User $user): void
    {
    }
}
