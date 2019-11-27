<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\RoleByNameQuery;

class InMemoryRoleByNameQuery implements RoleByNameQuery
{
    private $roleRepository;

    /**
     * InMemoryRoleQuery constructor.
     */
    public function __construct(object $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function execute(RoleName $roleName): ?Role
    {
        return $this->roleRepository->findByRoleName($roleName);
    }
}
