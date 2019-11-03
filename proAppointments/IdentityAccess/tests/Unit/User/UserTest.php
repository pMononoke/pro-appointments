<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\FullName;
use ProAppointments\IdentityAccess\Domain\User\LastName;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

class UserTest extends TestCase
{
    private const EMAIL = 'irrelevant@email.com';
    private const PASSWORD = 'irrelevant';
    private const FIRST_NAME = 'irrelevant';
    private const LAST_NAME = 'irrelevant';

    /** @test */
    public function can_be_created(): void
    {
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $user = User::register(
            $id = UserId::generate(),
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $fullName
        );

        self::assertInstanceOf(User::class, $user);
        self::assertInstanceOf(UserId::class, $user->id());
        self::assertInstanceOf(UserEmail::class, $user->email());
        self::assertInstanceOf(UserPassword::class, $user->password());
        self::assertInstanceOf(FullName::class, $user->personalName());
    }

    /** @test */
    public function can_be_created_without_personalName(): void
    {
        $user = User::register(
            $id = UserId::generate(),
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD)
        );

        self::assertInstanceOf(User::class, $user);
        self::assertNull($user->personalName());
    }

    /** @test */
    public function can_change_personal_name(): void
    {
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $newFullName = new FullName(
            $newFirstName = FirstName::fromString('new'),
            $newLastName = LastName::fromString('new')
        );
        $user = User::register(
            $id = UserId::generate(),
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $fullName
        );

        $user->changePersonalName($newFullName);

        self::assertTrue($user->personalName()->equals($newFullName));
    }

    /** @test */
    public function can_be_compared(): void
    {
        $firstUser = User::register(
            $id = UserId::generate(),
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD)
        );
        $secondUser = User::register(
            UserId::generate(),
            UserEmail::fromString('second@email.com'),
            UserPassword::fromString('second')
        );
        $copyOfFirstUser = User::register(
            $id,
            $email,
            $password
        );

        self::assertFalse($firstUser->sameIdentityAs($secondUser));
        self::assertTrue($firstUser->sameIdentityAs($copyOfFirstUser));
        self::assertFalse($secondUser->sameIdentityAs($copyOfFirstUser));
    }
}
