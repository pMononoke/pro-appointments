<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use Doctrine\Common\Collections\ArrayCollection;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;

class InMemoryRoleRepository implements ReadWriteRoleRepository
{
    /** @var ArrayCollection */
    private $rolesCollection;

    public function __construct()
    {
        $this->rolesCollection = new ArrayCollection([]);
    }

    public function nextIdentity(): RoleId
    {
        return RoleId::generate();
    }

    /**
     * @throws RoleAlreadyExist
     */
    public function add(Role $role): void
    {
        if ($this->roleExist($role->id())) {
            throw RoleAlreadyExist::withId($role->id());
        }

        $this->rolesCollection->set($role->id()->toString(), $role);
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
        if (!$this->roleExist($role->id())) {
            throw RoleNotFound::withId($role->id());
        }

        $this->rolesCollection->set($role->id()->toString(), $role);
    }

    public function remove(Role $role): void
    {
        $this->rolesCollection->remove($role->id()->toString());

        // TODO should throw exception? or should silent logging e continue the flow?
        //throw new RoleNotFound($role->Id());
    }

    public function roleExist(RoleId $roleId): bool
    {
        return $this->rolesCollection->containsKey($roleId->toString());
    }

    /** READ SIDE QUERY */
    public function findById(RoleId $roleId): ?Role
    {
        return $this->rolesCollection->get($roleId->toString());
    }

    /** READ SIDE QUERY */
    public function findAll(int $limit): array
    {
        return $this->rolesCollection->toArray();
    }

    /** READ SIDE QUERY */
    public function findByRoleName(RoleName $roleName): ?Role
    {
        $rolesByName = $this->rolesCollection->filter(function (Role $role) use ($roleName) {
            return $role->name()->equals($roleName);
        });

        if ($rolesByName->isEmpty()) {
            return null;
        }

        return $rolesByName->first();
    }
}
