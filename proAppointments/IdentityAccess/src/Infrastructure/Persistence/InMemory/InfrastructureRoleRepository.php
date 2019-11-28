<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;

interface InfrastructureRoleRepository extends RoleRepository
{
    public function allRoles(): array;
}
