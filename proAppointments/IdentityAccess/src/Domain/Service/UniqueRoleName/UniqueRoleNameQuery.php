<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;

interface UniqueRoleNameQuery
{
    public function execute(RoleName $roleName): bool;
}
