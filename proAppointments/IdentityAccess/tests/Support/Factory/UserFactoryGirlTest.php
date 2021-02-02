<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Support\Factory;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;

class UserFactoryGirlTest extends TestCase
{
    /** @var UserFactoryGirl */
    private $factory;

    protected function setUp()
    {
        $this->factory = new UserFactoryGirl();
    }

    /** @test */
    public function itCanBuildOneUser(): void
    {
        self::assertInstanceOf(User::class, $this->factory->build());
    }

    /** @test */
    public function itCanBuildOneUserFromData(): void
    {
        $data = [
            'id' => UserId::generate(),
            'email' => UserEmail::fromString('admin@example.com'),
            'password' => UserPassword::fromString('foo'),
            'firstName' => FirstName::fromString('admin joe'),
            'lastName' => LastName::fromString('doe'),
            'mobileNumber' => MobileNumber::fromString('+39-392-5555555'),
        ];
        self::assertInstanceOf(User::class, $this->factory->build($data));
    }

    /** @test */
    public function itCanBuildManyUser(): void
    {
        $desiredInstance = 3;

        $results = $this->factory->buildMany($desiredInstance);

        self::assertIsArray($results);
        self::assertCount($desiredInstance, $results);
    }

    protected function tearDown()
    {
        $this->factory = null;
    }
}
