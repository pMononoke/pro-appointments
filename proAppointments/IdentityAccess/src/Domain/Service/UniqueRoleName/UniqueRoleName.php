<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleNameInterface as UniqueRoleNamePort;

class UniqueRoleName implements UniqueRoleNamePort
{
    /** @var UniqueRoleNameQuery */
    private $query;

    public function __construct(UniqueRoleNameQuery $query)
    {
        $this->query = $query;
    }

    public function __invoke(RoleName $roleName): bool
    {
        // TODO add custom exception ImpossibleToRetrive(Data)
        return $this->query->execute($roleName);
    }
}
