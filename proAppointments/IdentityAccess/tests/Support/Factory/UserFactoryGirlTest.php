<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Support\Factory;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Identity\User;

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
