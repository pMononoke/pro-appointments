<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleNameQuery;

class InMemoryUniqueRoleNameQuery implements UniqueRoleNameQuery
{
    /** @var InMemoryRoleRepository */
    private $roleRepository;

    public function __construct(InMemoryRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function execute(RoleName $roleName): bool
    {
        return $this->roleRepository->findUniqueRoleName($roleName);
    }
}
