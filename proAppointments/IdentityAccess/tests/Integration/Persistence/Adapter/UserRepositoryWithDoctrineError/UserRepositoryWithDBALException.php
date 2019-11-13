<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter\UserRepositoryWithDoctrineError;

use Doctrine\DBAL\DBALException;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;

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
}
