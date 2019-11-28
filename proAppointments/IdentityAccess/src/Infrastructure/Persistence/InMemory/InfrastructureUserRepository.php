<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserRepository;

interface InfrastructureUserRepository extends UserRepository
{
    public function userExist(UserId $userId): bool;

    /** READ SIDE QUERY */
    public function findById(UserId $userId): ?User;
}