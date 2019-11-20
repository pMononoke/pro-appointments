<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User\Event;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\Event\AccessCredentialsWasChanged;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

class AccessCredentialsWasChangedTest extends TestCase
{
    /** @test */
    public function can_be_created(): void
    {
        $event = new AccessCredentialsWasChanged(
            $userId = UserId::generate(),
            $password = UserPassword::fromString('irrelevant')
        );

        self::assertEquals($userId, $event->userId());
        self::assertEquals($password, $event->password());
        self::assertNotNull($event->occurredOn());
    }

    /** @test */
    public function can_return_the_payload(): void
    {
        $event = new AccessCredentialsWasChanged(
            $userId = UserId::generate(),
            $password = UserPassword::fromString('irrelevant')
        );

        $expectedPayload = [
            'userId' => $userId->toString(),
            'password' => $password->toString(),
        ];

        self::assertEquals($expectedPayload, $event->toPayload());
    }
}
