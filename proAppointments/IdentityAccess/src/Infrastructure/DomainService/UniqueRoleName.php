<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\DomainService;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\RoleByNameQuery;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleName as UniqueRoleNamePort;

class UniqueRoleName implements UniqueRoleNamePort
{
    /** @var RoleByNameQuery */
    private $query;

    /**
     * UniqueRoleName constructor.
     */
    public function __construct(RoleByNameQuery $query)
    {
        $this->query = $query;
    }

    public function __invoke(RoleName $roleName): bool
    {
        $isUnique = false;

        if (!$this->query->execute($roleName)) {
            $isUnique = true;
        }

        return $isUnique;
    }
}
