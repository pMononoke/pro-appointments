<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;

interface UniqueRoleNameInterface
{
    public function __invoke(RoleName $roleName): bool;
}
