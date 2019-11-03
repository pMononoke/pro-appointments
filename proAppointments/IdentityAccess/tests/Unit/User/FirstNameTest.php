<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\FirstName;

class FirstNameTest extends TestCase
{
    private const FIRST_NAME = 'Irrelevant';

    /** @test */
    public function can_be_created_from_string(): void
    {
        $firstName = FirstName::fromString(self::FIRST_NAME);

        self::assertInstanceOf(FirstName::class, $firstName);
        self::assertEquals(self::FIRST_NAME, $firstName->toString());
    }

    /** @test */
    public function can_be_compared(): void
    {
        $first = FirstName::fromString(self::FIRST_NAME);
        $second = FirstName::fromString('other irrelevant');
        $copyOfFirst = FirstName::fromString(self::FIRST_NAME);

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
        FirstName::fromString('a');
    }
}
