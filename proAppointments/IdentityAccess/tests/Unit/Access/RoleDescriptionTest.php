<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\Access;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Access\RoleDescription;

class RoleDescriptionTest extends TestCase
{
    private const ROLE_DESCRIPTION = 'Irrelevant';

    /** @test */
    public function can_be_created_from_string(): void
    {
        $firstName = RoleDescription::fromString(self::ROLE_DESCRIPTION);

        self::assertInstanceOf(RoleDescription::class, $firstName);
        self::assertEquals(self::ROLE_DESCRIPTION, $firstName->toString());
        self::assertEquals(self::ROLE_DESCRIPTION, $firstName->__toString());
    }

    /** @test */
    public function can_be_compared(): void
    {
        $first = RoleDescription::fromString(self::ROLE_DESCRIPTION);
        $second = RoleDescription::fromString('other irrelevant');
        $copyOfFirst = RoleDescription::fromString(self::ROLE_DESCRIPTION);

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
        RoleDescription::fromString('a');
    }
}
