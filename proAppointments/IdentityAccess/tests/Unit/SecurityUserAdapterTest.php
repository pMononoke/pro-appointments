<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Security\SecurityUserAdapter;
use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;

class SecurityUserAdapterTest extends TestCase
{
    use UserFixtureBehavior;

    /** @test */
    public function shouldExposeInternalUserIdAsString(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $adapter = new SecurityUserAdapter($user);

        self::assertIsString($adapter->getUsername());
        self::assertEquals($id->toString(), $adapter->getId());
    }

    /** @test */
    public function shouldExposeInternalEmailAsUsername(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $adapter = new SecurityUserAdapter($user);

        self::assertIsString($adapter->getUsername());
        self::assertEquals('irrelevant@email.com', $adapter->getUsername());
        //self::assertSame('irrelevant@email.com', $adapter->getUsername());
    }

    /** @test */
    public function shouldExposeInternalPassword(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $adapter = new SecurityUserAdapter($user);

        self::assertEquals('irrelevant', $adapter->getPassword());
    }

    /** @test */
    public function shouldExposeInternalUserRoles(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $adapter = new SecurityUserAdapter($user);

        self::assertEquals(['ROLE_USER'], $adapter->getRoles());
    }

    /** @test */
    public function saltMethodShouldReturnAnEmptyString(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $adapter = new SecurityUserAdapter($user);

        self::assertEquals('', $adapter->getSalt());
    }
}
