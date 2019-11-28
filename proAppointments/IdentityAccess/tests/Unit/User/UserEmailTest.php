<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;

class UserEmailTest extends TestCase
{
    private const EMAIL = 'irrelevant@example.com';

    /** @test */
    public function can_be_created_from_string(): void
    {
        $firstName = UserEmail::fromString(self::EMAIL);

        self::assertInstanceOf(UserEmail::class, $firstName);
        self::assertEquals(self::EMAIL, $firstName->toString());
        self::assertEquals(self::EMAIL, $firstName->__toString());
    }

    /** @test */
    public function can_be_compared(): void
    {
        $first = UserEmail::fromString(self::EMAIL);
        $second = UserEmail::fromString('other-irrelevant@example.com');
        $copyOfFirst = UserEmail::fromString(self::EMAIL);

        self::assertFalse($first->equals($second));
        self::assertTrue($first->equals($copyOfFirst));
        self::assertFalse($second->equals($copyOfFirst));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function a_short_email_throw_exception(): void
    {
        UserEmail::fromString('a');
    }
}
