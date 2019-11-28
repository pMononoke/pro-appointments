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
use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;

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

        $person = new Person($userId, $fullName, $contactInformation);

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
        $person = new Person($userId, $fullName, $contactInformation);

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
        $person = new Person($userId, $fullName, $contactInformation);

        $person->changeContactInformation($newContactInformation);

        self::assertTrue($person->contactInformation()->equals($newContactInformation));
    }

    /** @test */
    public function can_be_compared(): void
    {
        $firstPerson = new Person(
            $userId = UserId::generate(),
            new FullName(
                $firstName = FirstName::fromString(self::FIRST_NAME),
                $lastName = LastName::fromString(self::LAST_NAME)
            ),
            new ContactInformation(
                $email = UserEmail::fromString(self::EMAIL),
                $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
            )
        );
        $secondPerson = new Person(
            UserId::generate(),
            new FullName(
                FirstName::fromString('second'),
                LastName::fromString('second')
            ),
            new ContactInformation(
                $email = UserEmail::fromString('second@example.com'),
                $mobileNumber = MobileNumber::fromString('+39-392-2222222')
            )
        );
        $copyOfFirstPerson = new Person(
            $userId,
            new FullName(
                $firstName = FirstName::fromString(self::FIRST_NAME),
                $lastName = LastName::fromString(self::LAST_NAME)
            ),
            new ContactInformation(
                $email = UserEmail::fromString(self::EMAIL),
                $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
            )
        );

        self::assertFalse($firstPerson->equals($secondPerson));
        self::assertTrue($firstPerson->equals($copyOfFirstPerson));
        self::assertFalse($secondPerson->equals($copyOfFirstPerson));
    }
}
