<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\NullRepository;

use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;

class NullRoleRepository implements RoleRepository
{
    public function nextIdentity(): RoleId
    {
    }

    public function add(Role $role): void
    {
    }

    public function ofId(RoleId $roleId): Role
    {
    }

    public function update(Role $role): void
    {
    }

    public function remove(Role $role): void
    {
    }

    public function roleExist(RoleId $roleId): bool
    {
    }
}
