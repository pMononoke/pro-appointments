<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\Access;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRemoveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRetrieveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleExceptionInterface;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;

class RoleExceptionsTest extends TestCase
{
    private const UUID = '100ade38-ad18-4cf4-9ac5-de2b00c4abb7';

    /** @test */
    public function RoleNotFound_exception_can_be_throw()
    {
        $this->expectException(RoleNotFound::class);

        $this->expectExceptionMessage('Role '.self::UUID.' does not exist.');

        throw  RoleNotFound::withId($roleId = RoleId::fromString(self::UUID));
    }

    /** @test */
    public function RoleNotFound_exception_can_return_role_id()
    {
        $e = RoleNotFound::withId($roleId = RoleId::fromString(self::UUID));

        self::assertTrue($roleId->equals($e->id()));
        self::assertInstanceOf(RoleExceptionInterface::class, $e);
    }

    /** @test */
    public function RoleAlreadyExist_exception_can_be_throw()
    {
        $this->expectException(RoleAlreadyExist::class);

        $this->expectExceptionMessage('Role '.self::UUID.' already exist.');

        throw  RoleAlreadyExist::withId($roleId = RoleId::fromString(self::UUID));
    }

    /** @test */
    public function RoleAlreadyExist_exception_can_return_user_id()
    {
        $e = RoleAlreadyExist::withId($roleId = RoleId::fromString(self::UUID));

        self::assertTrue($roleId->equals($e->id()));
        self::assertInstanceOf(RoleExceptionInterface::class, $e);
    }

    /** @test */
    public function ImpossibleToSaveRole_exception_can_be_throw()
    {
        $this->expectException(ImpossibleToSaveRole::class);

        $this->expectExceptionMessage('Test message.');

        throw new ImpossibleToSaveRole('Test message.');
    }

    /** @test */
    public function ImpossibleToRetrieveRole_exception_can_be_throw()
    {
        $this->expectException(ImpossibleToRetrieveRole::class);

        $this->expectExceptionMessage('Test message.');

        throw new ImpossibleToRetrieveRole('Test message.');
    }

    /** @test */
    public function ImpossibleToRemoveRole_exception_can_be_throw()
    {
        $this->expectException(ImpossibleToRemoveRole::class);

        $this->expectExceptionMessage('Test message.');

        throw new ImpossibleToRemoveRole('Test message.');
    }
}
