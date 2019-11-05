<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

class UserFactory
{
    public function build(
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

    public function buildDefaultUser(): User
    {
        $userId = UserId::generate();
        $fullName = new FullName(
            FirstName::fromString('default name'),
            LastName::fromString('default last name')
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString('default@example.com'),
            MobileNumber::fromString('+39-392-9999999'));
        $person = new Person($userId, $fullName, $contactInformation);

        $user = User::register($userId, $email, UserPassword::fromString('default'), $person);

        return $user;
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

        $person = new Person($userId, $fullName, $contactInformation);

        $user = User::register($userId, $email, $password, $person);

        return $user;
    }

    public function buildWithAccountData(
        UserId $userId,
        UserEmail $email,
        UserPassword $password
    ): User {
        // TODO issue #2
        $user = User::register($userId, $email, $password);

        return $user;
    }
}
