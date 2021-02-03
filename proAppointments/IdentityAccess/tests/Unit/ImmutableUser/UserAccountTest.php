<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\ImmutableUser;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Application\ViewModel\UserAccount;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Tests\Support\Factory\UserFactoryGirl;

class UserAccountTest extends TestCase
{
    /** @var UserFactoryGirl */
    private $factory;

    protected function setUp()
    {
        $this->factory = new UserFactoryGirl();
    }

    /** @test */
    public function canBeCreateFromFullUserModel(): void
    {
        $userModel = $this->factory->build();

        $userAccount = new UserAccount($userModel);

        self::assertInstanceOf(UserAccount::class, $userAccount);
        self::assertEquals($userModel->id()->toString(), $userAccount->id());
        self::assertEquals($userModel->email()->toString(), $userAccount->email());
        self::assertEquals($userModel->person()->name()->firstName()->toString(), $userAccount->firstName());
        self::assertEquals($userModel->person()->name()->lastName()->toString(), $userAccount->lastName());
        self::assertEquals($userModel->person()->contactInformation()->email()->toString(), $userAccount->contactEmail());
        self::assertEquals($userModel->person()->contactInformation()->mobileNumber()->toString(), $userAccount->contactNumber());
    }

    /** @test */
    public function canBeCreateFromMinimumUserModel(): void
    {
        $data = [
            'id' => UserId::generate(),
            'email' => UserEmail::fromString('irrelevant@example.com'),
            'password' => UserPassword::fromString('irrelevant'),
        ];

        $userModel = $this->factory->build($data);

        $userAccount = new UserAccount($userModel);

        self::assertInstanceOf(UserAccount::class, $userAccount);
        self::assertEquals($userModel->id()->toString(), $userAccount->id());
        self::assertEquals($userModel->email()->toString(), $userAccount->email());
        self::assertEquals($userModel->person()->contactInformation()->email()->toString(), $userAccount->contactEmail());

        self::assertNull($userAccount->firstName());
        self::assertNull($userAccount->lastName());
        self::assertNull($userAccount->contactNumber());
    }

    protected function tearDown()
    {
        $this->factory = null;
    }
}
