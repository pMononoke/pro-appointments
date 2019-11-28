<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\UnknownRepository;

use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleException;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;

class UnknownRoleRepository implements RoleRepository
{
    private const EXCEPTION_MESSAGE = 'Unknown Role Repository. Please check your configuration.';

    public function nextIdentity(): RoleId
    {
        throw new RoleException(self::EXCEPTION_MESSAGE);
    }

    public function add(Role $role): void
    {
        throw new RoleException(self::EXCEPTION_MESSAGE);
    }

    public function ofId(RoleId $roleId): Role
    {
        throw new RoleException(self::EXCEPTION_MESSAGE);
    }

    public function update(Role $role): void
    {
        throw new RoleException(self::EXCEPTION_MESSAGE);
    }

    public function remove(Role $role): void
    {
        throw new RoleException(self::EXCEPTION_MESSAGE);
    }

    public function roleExist(Role $role): bool
    {
        throw new RoleException(self::EXCEPTION_MESSAGE);
    }
}
