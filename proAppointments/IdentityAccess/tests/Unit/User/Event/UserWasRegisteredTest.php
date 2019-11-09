<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User\Event;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\Event\UserWasRegistered;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

class UserWasRegisteredTest extends TestCase
{
    /** @test */
    public function can_be_created(): void
    {
        $event = new UserWasRegistered(
            $userId = UserId::generate(),
            $email = UserEmail::fromString('irrelevant@excample.com')
        );

        self::assertEquals($userId, $event->userId());
        self::assertEquals($email, $event->email());
        self::assertNull($event->password());
        self::assertNotNull($event->occurredOn());
    }

    /** @test */
    public function can_be_created_with_optional_param(): void
    {
        $event = new UserWasRegistered(
            $userId = UserId::generate(),
            $email = UserEmail::fromString('irrelevant@excample.com'),
            $password = UserPassword::fromString('xxxxx')
        );

        self::assertEquals($userId, $event->userId());
        self::assertEquals($email, $event->email());
        self::assertEquals($password, $event->password());
        self::assertNotNull($event->occurredOn());
    }
}
