<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\Service\Query;

use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;

interface RoleQuery
{
    public function execute(RoleId $id): ?Role;
}
