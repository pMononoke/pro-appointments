<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter\UserRepositoryWithDoctrineError;

use Doctrine\DBAL\DBALException;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class UserRepositoryWithDBALException
{
    public function register(User $user): void
    {
        throw DBALException:: invalidPlatformSpecified();
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
        throw DBALException:: invalidPlatformSpecified();
    }

    public function save(User $user): void
    {
        throw DBALException:: invalidPlatformSpecified();
    }
}
