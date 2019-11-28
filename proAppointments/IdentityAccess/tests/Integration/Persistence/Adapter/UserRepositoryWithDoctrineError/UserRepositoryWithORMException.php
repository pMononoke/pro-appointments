<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter\UserRepositoryWithDoctrineError;

use Doctrine\ORM\ORMException;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class UserRepositoryWithORMException
{
    public function register(User $user): void
    {
        throw ORMException::entityManagerClosed();
    }

    public function ofId(UserId $userId): void
    {
    }

    public function nextIdentity(): void
    {
        // This method doesn't use the doctrine library.
    }

    public function remove(User $user): void
    {
        throw ORMException::entityManagerClosed();
    }

    public function save(User $user): void
    {
        throw ORMException::entityManagerClosed();
    }
}
