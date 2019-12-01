<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;

interface ReadWriteRoleRepository extends RoleRepository
{
    public function roleExist(RoleId $roleId): bool;

    /** READ SIDE QUERY */
    public function findById(RoleId $roleId): ?Role;

    /** READ SIDE QUERY */
    public function findUniqueRoleName(RoleName $roleName): bool;

    /** READ SIDE QUERY */
    public function findAll(int $limit): array;
}
