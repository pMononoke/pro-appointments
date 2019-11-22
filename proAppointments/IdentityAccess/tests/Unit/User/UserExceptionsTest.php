<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\Exception\ImpossibleToRemoveUser;
use ProAppointments\IdentityAccess\Domain\User\Exception\ImpossibleToSaveUser;
use ProAppointments\IdentityAccess\Domain\User\Exception\UserAlreadyExist;
use ProAppointments\IdentityAccess\Domain\User\Exception\UserNotFound;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;

class UserExceptionsTest extends TestCase
{
    private const UUID = '100ade38-ad18-4cf4-9ac5-de2b00c4abb7';
    private const EMAIL = 'irrelevant@email.com';

    /** @test */
    public function UserNotFound_exception_can_be_throw()
    {
        $this->expectException(UserNotFound::class);

        $this->expectExceptionMessage('User '.self::UUID.' does not exist.');

        throw  UserNotFound::withId($userId = UserId::fromString(self::UUID));
    }

    /** @test */
    public function UserNotFound_exception_can_return_user_id()
    {
        $e = UserNotFound::withId($userId = UserId::fromString(self::UUID));

        self::assertTrue($userId->equals($e->id()));
    }

    /** @test */
    public function UserNotFound_exception_can_be_throw_with_user_email()
    {
        $this->expectException(UserNotFound::class);

        $this->expectExceptionMessage('User with email '.self::EMAIL.' does not exist.');

        throw  UserNotFound::withEmail($email = UserEmail::fromString(self::EMAIL), UserId::fromString(self::UUID));
    }

    /** @test */
    public function UserAlreadyExist_exception_can_be_throw()
    {
        $this->expectException(UserAlreadyExist::class);

        $this->expectExceptionMessage('User '.self::UUID.' already exist.');

        throw  UserAlreadyExist::withId(UserId::fromString(self::UUID));
    }

    /** @test */
    public function UserAlreadyExist_exception_can_return_user_id()
    {
        $e = UserAlreadyExist::withId($userId = UserId::fromString(self::UUID));

        self::assertTrue($userId->equals($e->id()));
    }

    /** @test */
    public function ImpossibleToSaveUser_exception_can_be_throw()
    {
        $this->expectException(ImpossibleToSaveUser::class);

        $this->expectExceptionMessage('Can not save user '.self::UUID.' persistence layer error.');

        throw ImpossibleToSaveUser::withId($userId = UserId::fromString(self::UUID));
    }

    /** @test */
    public function ImpossibleToSaveUser_exception_can_return_user_id()
    {
        $e = ImpossibleToSaveUser::withId($userId = UserId::fromString(self::UUID));

        self::assertTrue($userId->equals($e->id()));
    }

    /** @test */
    public function ImpossibleToRemoveUser_exception_can_be_throw()
    {
        $this->expectException(ImpossibleToRemoveUser::class);

        $this->expectExceptionMessage('Can not remove user '.self::UUID.' persistence layer error.');

        throw ImpossibleToRemoveUser::withId($userId = UserId::fromString(self::UUID));
    }

    /** @test */
    public function ImpossibleToRemoveUser_exception_can_return_user_id()
    {
        $e = ImpossibleToRemoveUser::withId($userId = UserId::fromString(self::UUID));

        self::assertTrue($userId->equals($e->id()));
    }
}
