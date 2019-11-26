<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;

class InMemoryRoleRepository implements RoleRepository
{
    private $rolesCollection = [];

    public function nextIdentity(): RoleId
    {
        return RoleId::generate();
    }

    /**
     * @throws RoleAlreadyExist
     */
    public function add(Role $role): void
    {
        $this->rolesCollection[$role->Id()->toString()] = $role;
    }

    /**
     * @throws RoleNotFound
     */
    public function ofId(RoleId $roleId): Role
    {
        if (!$this->roleExist($roleId)) {
            throw RoleNotFound::withId($roleId);
        }

        return $this->rolesCollection[$roleId->toString()];
    }

    /**
     * @throws RoleNotFound
     */
    public function update(Role $role): void
    {
        $this->rolesCollection[$role->Id()->toString()] = $role;
    }

    public function remove(Role $role): void
    {
        if (array_key_exists($role->Id()->toString(), $this->rolesCollection)) {
            unset($this->rolesCollection[$role->Id()->toString()]);
        }
        // TODO should throw exception? or should silent logging e continue the flow?
        //throw new RoleNotFound($role->Id());
    }

    public function roleExist(RoleId $roleId): bool
    {
        $exist = false;

        if (array_key_exists($roleId->toString(), $this->rolesCollection)) {
            $exist = true;
        }

        return $exist;
    }
}
