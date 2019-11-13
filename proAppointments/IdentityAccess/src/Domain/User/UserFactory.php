<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

class UserFactory
{
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

        $person = new Person($userId, $fullName, $contactInformation);

        $user = User::register($userId, $email, $password, $person);

        return $user;
    }
}
