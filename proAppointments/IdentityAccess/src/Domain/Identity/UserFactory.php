<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity;

class UserFactory
{
    public function buildWithMinimumData(
        UserId $userId,
        UserEmail $email,
        UserPassword $password
        ): User {
        return User::registerWithMinimumData($userId, $email, $password);
    }

    public function buildWithContactInformation(
        UserId $userId,
        UserEmail $email,
        UserPassword $password,
        FirstName $firstName,
        LastName $lastName,
        MobileNumber $mobileNumber): User
    {
        $fullName = new FullName($firstName, $lastName);

        $contactInformation = new ContactInformation($email, $mobileNumber);

        $person = new Person($userId, $contactInformation, $fullName);

        return User::register($userId, $email, $password, $person);
    }
}
