<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\UnknownRepository;

use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleException;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;

class UnknownRoleRepository implements RoleRepository
{
    public function nextIdentity(): RoleId
    {
        throw new RoleException('Unknown Role Repository. Please check your configuration.');
    }

    public function add(Role $role): void
    {
        throw new RoleException('Unknown Role Repository. Please check your configuration.');
    }

    public function ofId(RoleId $roleId): Role
    {
        throw new RoleException('Unknown Role Repository. Please check your configuration.');
    }

    public function update(Role $role): void
    {
        throw new RoleException('Unknown Role Repository. Please check your configuration.');
    }

    public function remove(Role $role): void
    {
        throw new RoleException('Unknown Role Repository. Please check your configuration.');
    }

    public function roleExist(Role $role): bool
    {
        throw new RoleException('Unknown Role Repository. Please check your configuration.');
    }
}
