<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\DataFixtures;

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

trait UserFixtureBehavior
{
    protected function generateUserAggregate(): array
    {
        $id = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString('irrelevant'),
            $lastName = LastName::fromString('irrelevant')
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString('irrelevant@email.com'),
            $mobileNumber = MobileNumber::fromString('+39-392-1111111')
        );
        $person = new Person($id, $fullName, $contactInformation);
        $user = User::register(
            $id,
            $email = UserEmail::fromString('irrelevant@email.com'),
            $password = UserPassword::fromString('irrelevant'),
            $person
        );

        return [$id, $user];
    }
}
