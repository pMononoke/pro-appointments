<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName;

use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;

interface RoleByNameQuery
{
    public function execute(RoleName $roleName): ?Role;
}
