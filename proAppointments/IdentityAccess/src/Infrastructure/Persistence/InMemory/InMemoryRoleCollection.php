<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;

class InMemoryRoleCollection
{
    /** @var InfrastructureRoleRepository */
    private $roleRepository;

    /** @var Collection */
    private $roleCollection;

    /**
     * InMemoryRoleCollection constructor.
     */
    public function __construct(InfrastructureRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function findById(RoleId $id): ?Role
    {
        $this->roleCollection = new ArrayCollection($this->roleRepository->allRoles());

        return $this->roleCollection->get($id->toString());
    }

    public function findByRoleName(RoleName $roleName): ?Role
    {
        $this->roleCollection = new ArrayCollection($this->roleRepository->allRoles());

        $rolesByName = $this->roleCollection->filter(function (Role $role) use ($roleName) {
            return $role->name()->equals($roleName);
        });

        if ($rolesByName->isEmpty()) {
            return null;
        }

        return $rolesByName->first();
    }
}
