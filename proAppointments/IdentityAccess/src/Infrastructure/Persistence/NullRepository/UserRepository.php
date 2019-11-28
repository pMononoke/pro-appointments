<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\NullRepository;

use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository as UserRepositoryPort;

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

    public function save(User $user): void
    {
    }
}
