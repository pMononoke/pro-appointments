<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\Access;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleDescription;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;

class RoleTest extends TestCase
{
    private const ROLE_NAME = 'irrelevant';
    private const ROLE_DESCRIPTION = 'irrelevant';

    /** @test */
    public function can_be_created(): void
    {
        $id = RoleId::generate();
        $name = RoleName::fromString(self::ROLE_NAME);
        $role = new Role($id, $name);

        self::assertInstanceOf(Role::class, $role);
        self::assertInstanceOf(RoleId::class, $role->id());
        self::assertTrue($id->equals($role->id()));
        self::assertInstanceOf(RoleName::class, $role->name());
        self::assertTrue($name->equals($role->name()));
        self::assertNull($role->description());
    }

    /** @test */
    public function can_be_created_with_role_description(): void
    {
        $id = RoleId::generate();
        $name = RoleName::fromString(self::ROLE_NAME);
        $description = RoleDescription::fromString(self::ROLE_DESCRIPTION);
        $role = new Role($id, $name, $description);

        self::assertInstanceOf(Role::class, $role);
        self::assertInstanceOf(RoleId::class, $role->id());
        self::assertTrue($id->equals($role->id()));
        self::assertInstanceOf(RoleDescription::class, $role->description());
        self::assertTrue($description->equals($role->description()));
    }

    /** @test */
    public function can_be_compared(): void
    {
        $firstRole = new Role(
            $id = RoleId::generate(),
            $name = RoleName::fromString(self::ROLE_NAME),
            $description = RoleDescription::fromString(self::ROLE_DESCRIPTION)
        );
        $secondRole = new Role(
            $secondId = RoleId::generate(),
            $secondName = RoleName::fromString('other-role')
        );
        $copyOfFirstRole = new Role(
            $id,
            $name = RoleName::fromString(self::ROLE_NAME),
            $description = RoleDescription::fromString(self::ROLE_DESCRIPTION)
        );

        self::assertFalse($firstRole->sameIdentityAs($secondRole));
        self::assertTrue($firstRole->sameIdentityAs($copyOfFirstRole));
        self::assertFalse($secondRole->sameIdentityAs($copyOfFirstRole));
    }
}
