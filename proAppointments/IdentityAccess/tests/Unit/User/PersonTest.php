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
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class PersonTest extends TestCase
{
    private const FIRST_NAME = 'irrelevant';
    private const LAST_NAME = 'irrelevant';
    private const EMAIL = 'irrelevant@examle.com';
    private const MOBILE_NUMBER = '+39-392-1111111';

    /** @test */
    public function can_be_created(): void
    {
        $userId = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );

        $person = new Person($userId, $contactInformation, $fullName);

        self::assertEquals($userId, $person->userId());
        self::assertEquals($fullName, $person->name());
        self::assertEquals($contactInformation, $person->contactInformation());
    }

    /** @test */
    public function can_change_name(): void
    {
        $userId = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $newFullName = new FullName(
            $newFirstName = FirstName::fromString('new'),
            $newLastName = LastName::fromString('new')
        );
        $person = new Person($userId, $contactInformation, $fullName);

        $person->changeName($newFullName);

        self::assertTrue($person->name()->equals($newFullName));
    }

    /** @test */
    public function can_add_name_when_name_is_unknown(): void
    {
        $userId = UserId::generate();
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $newFullName = new FullName(
            $newFirstName = FirstName::fromString('new'),
            $newLastName = LastName::fromString('new')
        );
        $person = new Person($userId, $contactInformation);

        $person->changeName($newFullName);

        self::assertTrue($person->name()->equals($newFullName));
    }

    /** @test */
    public function can_change_contact_information(): void
    {
        $userId = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $newContactInformation = new ContactInformation(
            $newemail = UserEmail::fromString('new@example.com'),
            $newMobileNumber = MobileNumber::fromString('+39-392-2222222')
        );
        $person = new Person($userId, $contactInformation, $fullName);

        $person->changeContactInformation($newContactInformation);

        self::assertTrue($person->contactInformation()->equals($newContactInformation));
    }

    /** @test */
    public function can_add_mobile_number_to_contact_information(): void
    {
        $userId = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
//            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $newContactInformation = new ContactInformation(
            $newemail = UserEmail::fromString('new@example.com'),
            $newMobileNumber = MobileNumber::fromString('+39-392-2222222')
        );
        $person = new Person($userId, $contactInformation, $fullName);

        $person->changeContactInformation($newContactInformation);

        self::assertTrue($person->contactInformation()->equals($newContactInformation));
        self::assertTrue($person->contactInformation()->mobileNumber()->equals($newMobileNumber));
    }

    /** @test */
    public function can_be_compared(): void
    {
        $firstPerson = new Person(
            $userId = UserId::generate(),
            new ContactInformation(
                $email = UserEmail::fromString(self::EMAIL),
                $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
            ),
            new FullName(
                $firstName = FirstName::fromString(self::FIRST_NAME),
                $lastName = LastName::fromString(self::LAST_NAME)
            )
        );
        $secondPerson = new Person(
            UserId::generate(),
            new ContactInformation(
                $email = UserEmail::fromString('second@example.com'),
                $mobileNumber = MobileNumber::fromString('+39-392-2222222')
            ),
            new FullName(
                FirstName::fromString('second'),
                LastName::fromString('second')
            )
        );
        $copyOfFirstPerson = new Person(
            $userId,
            new ContactInformation(
                $email = UserEmail::fromString(self::EMAIL),
                $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
            ),
            new FullName(
                $firstName = FirstName::fromString(self::FIRST_NAME),
                $lastName = LastName::fromString(self::LAST_NAME)
            )
        );

        self::assertFalse($firstPerson->equals($secondPerson));
        self::assertTrue($firstPerson->equals($copyOfFirstPerson));
        self::assertFalse($secondPerson->equals($copyOfFirstPerson));
    }
}
