<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\DomainService;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserFactory;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;

class UserFactoryTest extends TestCase
{
    private const EMAIL = 'irrelevant@email.com';
    private const PASSWORD = 'irrelevant';
    private const FIRST_NAME = 'irrelevant';
    private const LAST_NAME = 'irrelevant';
    private const MOBILE_NUMBER = '+39-392-1111111';

    /** @test */
    public function can_build_user_with_contact_information(): void
    {
        $factory = new UserFactory();

        $user = $factory->buildWithContactInformation(
            $userId = UserId::generate(),
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );

        self::assertInstanceOf(User::class, $user);
        self::assertEquals($userId, $user->id());
        self::assertEquals($email, $user->email());
        self::assertEquals($password, $user->password());
        self::assertEquals($firstName, $user->person()->name()->firstName());
        self::assertEquals($lastName, $user->person()->name()->lastName());
        self::assertEquals($mobileNumber, $user->person()->contactInformation()->mobileNumber());
    }
}
