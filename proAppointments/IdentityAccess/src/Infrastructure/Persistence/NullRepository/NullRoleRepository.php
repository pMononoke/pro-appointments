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
        // TODO: Implement nextIdentity() method.
    }

    public function add(Role $role): void
    {
        // TODO: Implement add() method.
    }

    public function ofId(RoleId $roleId): Role
    {
        // TODO: Implement ofId() method.
        //return null;
    }

    public function update(Role $role): void
    {
        // TODO: Implement update() method.
    }

    public function remove(Role $role): void
    {
        // TODO: Implement remove() method.
    }

    public function roleExist(RoleId $roleId): bool
    {
        // TODO: Implement remove() method.
    }
}
