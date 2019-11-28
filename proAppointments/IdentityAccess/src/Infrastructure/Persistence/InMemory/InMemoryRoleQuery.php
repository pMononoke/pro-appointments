<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Application\Service\Query\RoleQuery;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;

class InMemoryRoleQuery implements RoleQuery
{
    private $roleRepository;

    /**
     * InMemoryRoleQuery constructor.
     */
    public function __construct(object $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function execute(RoleId $id): ?Role
    {
        return $this->roleRepository->findById($id);
    }
}
