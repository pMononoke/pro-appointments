<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\FullName;
use ProAppointments\IdentityAccess\Domain\User\LastName;

class FullNameTest extends TestCase
{
    private const FIRST_NAME = 'irrelevant';
    private const LAST_NAME = 'irrelevant';

    /** @test */
    public function can_be_created(): void
    {
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );

        self::assertEquals($firstName, $fullName->firstName());
        self::assertEquals($lastName, $fullName->lastName());
    }

    /** @test */
    public function can_be_compared(): void
    {
        $firstFullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $secondFullName = new FullName(
            FirstName::fromString('second'),
            LastName::fromString('second')
        );
        $copyOfFirstFullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );

        self::assertFalse($firstFullName->equals($secondFullName));
        self::assertTrue($firstFullName->equals($copyOfFirstFullName));
        self::assertFalse($secondFullName->equals($copyOfFirstFullName));
    }

    /** @test */
    public function it_return_a_new_FullName_value_object_when_modify_the_first_name(): void
    {
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $newFirstName = FirstName::fromString('new-irrelevant');

        $newFullName = $fullName->withFirstName($newFirstName);

        self::assertEquals('new-irrelevant', $newFullName->firstName()->toString());
        self::assertFalse($newFullName->equals($fullName));
    }

    /** @test */
    public function it_return_a_new_FullName_value_object_when_modify_the_last_name(): void
    {
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $newLastName = LastName::fromString('new-irrelevant');

        $newFullName = $fullName->withLastName($newLastName);

        self::assertEquals('new-irrelevant', $newFullName->lastName()->toString());
        self::assertFalse($newFullName->equals($fullName));
    }
}
