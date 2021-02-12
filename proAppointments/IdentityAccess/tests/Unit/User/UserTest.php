<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Identity\ContactInformation;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\FullName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\Person;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;

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
        $person = new Person($id, $contactInformation, $fullName);

        $user = User::register(
            $id,
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        self::assertInstanceOf(User::class, $user);
        self::assertInstanceOf(UserId::class, $user->id());
        self::assertInstanceOf(UserEmail::class, $user->email());
        self::assertSame(self::EMAIL, $user->email()->toString());
        self::assertInstanceOf(UserPassword::class, $user->password());
        self::assertSame(self::PASSWORD, $user->password()->toString());
        self::assertInstanceOf(Person::class, $user->person());
        self::assertSame(self::FIRST_NAME, $user->person()->name()->firstName()->toString());
        self::assertSame(self::LAST_NAME, $user->person()->name()->lastName()->toString());
        self::assertInstanceOf(ContactInformation::class, $user->person()->contactInformation());
        self::assertInstanceOf(MobileNumber::class, $user->person()->contactInformation()->mobileNumber());
        self::assertSame(self::MOBILE_NUMBER, $user->person()->contactInformation()->mobileNumber()->toString());
    }

    /** @test */
    public function can_be_created_with_Minimum_data(): void
    {
        $id = UserId::generate();
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
        );
        $person = new Person($id, $contactInformation);

        $user = User::register(
            $id,
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        self::assertInstanceOf(User::class, $user);
        self::assertInstanceOf(UserId::class, $user->id());
        self::assertInstanceOf(UserEmail::class, $user->email());
        self::assertSame(self::EMAIL, $user->email()->toString());
        self::assertInstanceOf(UserPassword::class, $user->password());
        self::assertSame(self::PASSWORD, $user->password()->toString());
        self::assertInstanceOf(Person::class, $user->person());
        self::assertNull($user->person()->name());
        self::assertInstanceOf(MobileNumber::class, $user->person()->contactInformation()->mobileNumber());
        self::assertSame('', $user->person()->contactInformation()->mobileNumber()->toString());
    }

    public function fullUserDataProvider(): array
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
        $person = new Person($id, $contactInformation, $fullName);

        $user = User::register(
            $id,
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        return [
            'user with full data' => [$user],
        ];
    }

    public function basicUserDataProvider(): array
    {
        $id = UserId::generate();
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
        );
        $person = new Person($id, $contactInformation);

        $user = User::register(
            $id,
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        return [
            'user with minimum data' => [$user],
        ];
    }

    /**
     * @test
     * @dataProvider fullUserDataProvider
     * @dataProvider basicUserDataProvider
     */
    public function can_change_personal_name(User $user): void
    {
        $newFullName = new FullName(
            $newFirstName = FirstName::fromString('new'),
            $newLastName = LastName::fromString('new')
        );

        $user->changePersonalName($newFullName);

        self::assertTrue($user->person()->name()->equals($newFullName));
    }

    /**
     * @test
     * @dataProvider fullUserDataProvider
     * @dataProvider basicUserDataProvider
     */
    public function can_change_access_credentials(User $user): void
    {
        $newPassword = UserPassword::fromString('new-password');

        $user->changeAccessCredentials($newPassword);

        self::assertTrue($user->password()->equals($newPassword));
    }

    /**
     * @test
     * @dataProvider fullUserDataProvider
     * @dataProvider basicUserDataProvider
     */
    public function can_change_contact_information(User $user): void
    {
        $newContactEmail = UserEmail::fromString('new-contact-email@example.com');
        $newContactMobileNumber = MobileNumber::fromString('+39 388 111111');
        $newContactInformation = new ContactInformation($newContactEmail, $newContactMobileNumber);

        $user->changeContactInformation($newContactInformation);

        self::assertTrue($user->person()->contactInformation()->email()->equals($newContactEmail));
        self::assertTrue($user->person()->contactInformation()->mobileNumber()->equals($newContactMobileNumber));
    }

    /** @test */
    public function can_be_compared_by_identity(): void
    {
        $firstUser = User::register(
            $id = UserId::generate(),
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person = new Person(
                $id,
                $contactInformation = new ContactInformation(
                    $email = UserEmail::fromString(self::EMAIL),
                    $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
                ),
                $fullName = new FullName(
                    $firstName = FirstName::fromString(self::FIRST_NAME),
                    $lastName = LastName::fromString(self::LAST_NAME)
                )
            )
        );
        $secondUser = User::register(
            UserId::generate(),
            UserEmail::fromString('second@email.com'),
            UserPassword::fromString('second'),
            $person = new Person(
                $id,
                $contactInformation = new ContactInformation(
                    $email = UserEmail::fromString(self::EMAIL),
                    $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
                ),
                $fullName = new FullName(
                    $firstName = FirstName::fromString(self::FIRST_NAME),
                    $lastName = LastName::fromString(self::LAST_NAME)
                )
            )
        );
        $copyOfFirstUser = User::register(
            $id,
            $email,
            $password,
            $person = new Person(
                $id,
                $contactInformation = new ContactInformation(
                    $email = UserEmail::fromString(self::EMAIL),
                    $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
                ),
                $fullName = new FullName(
                    $firstName = FirstName::fromString(self::FIRST_NAME),
                    $lastName = LastName::fromString(self::LAST_NAME)
                )
            )
        );

        self::assertFalse($firstUser->sameIdentityAs($secondUser));
        self::assertTrue($firstUser->sameIdentityAs($copyOfFirstUser));
        self::assertFalse($secondUser->sameIdentityAs($copyOfFirstUser));
    }
}
