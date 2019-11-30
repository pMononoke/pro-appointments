<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;

interface InfrastructureUserRepository extends UserRepository
{
    public function userExist(UserId $userId): bool;

    /** READ SIDE QUERY */
    public function findById(UserId $userId): ?User;

    /** READ SIDE QUERY */
    public function findAll(int $limit): array;

    /** READ SIDE QUERY */
    public function findUniqueUserEmail(UserEmail $userEmail): bool;
}
