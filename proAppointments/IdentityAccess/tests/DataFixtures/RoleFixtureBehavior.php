<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\DataFixtures;

use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleDescription;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;

trait RoleFixtureBehavior
{
    public function generateRoleAggregate(): Role
    {
        $id = RoleId::generate();
        $name = RoleName::fromString('irrelevant');
        $description = RoleDescription::fromString('irrelevant');
        $role = new Role($id, $name, $description);

        return $role;
    }
}
