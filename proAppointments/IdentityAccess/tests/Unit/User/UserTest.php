<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\ContactInformation;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\FullName;
use ProAppointments\IdentityAccess\Domain\User\LastName;
use ProAppointments\IdentityAccess\Domain\User\MobileNumber;
use ProAppointments\IdentityAccess\Domain\User\Person;
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
    private const MOBILE_NUMBER = '+39-392-1111111';

    /** @test */
    public function can_be_created(): void
    {
        $id = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $person = new Person($id, $fullName, $contactInformation);

        $user = User::register(
            $id,
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        self::assertInstanceOf(User::class, $user);
        self::assertInstanceOf(UserId::class, $user->id());
        self::assertInstanceOf(UserEmail::class, $user->email());
        self::assertInstanceOf(UserPassword::class, $user->password());
    }

    /** @test */
    public function can_change_personal_name(): void
    {
        $id = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $person = new Person($id, $fullName, $contactInformation);
        $newFullName = new FullName(
            $newFirstName = FirstName::fromString('new'),
            $newLastName = LastName::fromString('new')
        );
        $user = User::register(
            $id,
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        $user->changePersonalName($newFullName);

        self::assertTrue($user->person()->name()->equals($newFullName));
    }

    /** @test */
    public function can_change_access_credentials(): void
    {
        $id = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $person = new Person($id, $fullName, $contactInformation);
        $user = User::register(
            $id,
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );
        $newPassword = UserPassword::fromString('new-password');

        $user->changeAccessCredentials($newPassword);

        self::assertTrue($user->password()->equals($newPassword));
    }

    /** @test */
    public function can_be_compared(): void
    {
        $firstUser = User::register(
            $id = UserId::generate(),
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person = new Person(
                $id,
                $fullName = new FullName(
                    $firstName = FirstName::fromString(self::FIRST_NAME),
                    $lastName = LastName::fromString(self::LAST_NAME)
                ),
                $contactInformation = new ContactInformation(
                    $email = UserEmail::fromString(self::EMAIL),
                    $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
                )
            )
        );
        $secondUser = User::register(
            UserId::generate(),
            UserEmail::fromString('second@email.com'),
            UserPassword::fromString('second'),
            $person = new Person(
                $id,
                $fullName = new FullName(
                    $firstName = FirstName::fromString(self::FIRST_NAME),
                    $lastName = LastName::fromString(self::LAST_NAME)
                ),
                $contactInformation = new ContactInformation(
                    $email = UserEmail::fromString(self::EMAIL),
                    $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
                )
            )
        );
        $copyOfFirstUser = User::register(
            $id,
            $email,
            $password,
            $person = new Person(
                $id,
                $fullName = new FullName(
                    $firstName = FirstName::fromString(self::FIRST_NAME),
                    $lastName = LastName::fromString(self::LAST_NAME)
                ),
                $contactInformation = new ContactInformation(
                    $email = UserEmail::fromString(self::EMAIL),
                    $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
                )
            )
        );

        self::assertFalse($firstUser->sameIdentityAs($secondUser));
        self::assertTrue($firstUser->sameIdentityAs($copyOfFirstUser));
        self::assertFalse($secondUser->sameIdentityAs($copyOfFirstUser));
    }
}
