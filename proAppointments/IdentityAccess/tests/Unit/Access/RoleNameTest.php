<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\Access;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;

class RoleNameTest extends TestCase
{
    private const ROLE_NAME = 'Irrelevant';

    /** @test */
    public function can_be_created_from_string(): void
    {
        $roleName = RoleName::fromString(self::ROLE_NAME);

        self::assertInstanceOf(RoleName::class, $roleName);
        self::assertEquals(self::ROLE_NAME, $roleName->toString());
        self::assertEquals(self::ROLE_NAME, $roleName->__toString());
    }

    /** @test */
    public function can_be_compared(): void
    {
        $first = RoleName::fromString(self::ROLE_NAME);
        $second = RoleName::fromString('other irrelevant');
        $copyOfFirst = RoleName::fromString(self::ROLE_NAME);

        self::assertFalse($first->equals($second));
        self::assertTrue($first->equals($copyOfFirst));
        self::assertFalse($second->equals($copyOfFirst));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function a_short_firts_name_throw_exception(): void
    {
        RoleName::fromString('a');
    }
}
