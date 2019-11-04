<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

class UserPasswordTest extends TestCase
{
    private const PASSWORD = 'irrelevant';

    /** @test */
    public function can_be_created_from_string(): void
    {
        $firstName = UserPassword::fromString(self::PASSWORD);

        self::assertInstanceOf(UserPassword::class, $firstName);
        self::assertEquals(self::PASSWORD, $firstName->toString());
        self::assertEquals(self::PASSWORD, $firstName->__toString());
    }

    /** @test */
    public function can_be_compared(): void
    {
        $first = UserPassword::fromString(self::PASSWORD);
        $second = UserPassword::fromString('other irrelevant');
        $copyOfFirst = UserPassword::fromString(self::PASSWORD);

        self::assertFalse($first->equals($second));
        self::assertTrue($first->equals($copyOfFirst));
        self::assertFalse($second->equals($copyOfFirst));
    }
}
