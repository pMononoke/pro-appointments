<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User\Event;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Identity\Event\UserWasDeleted;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class UserWasDeletedTest extends TestCase
{
    /** @test */
    public function can_be_created(): void
    {
        $event = new UserWasDeleted(
            $userId = UserId::generate()
        );

        self::assertTrue($userId->equals($event->userId()));
        self::assertNotNull($event->occurredOn());
    }

    /** @test */
    public function can_return_the_payload(): void
    {
        $event = new UserWasDeleted(
            $userId = UserId::generate()
        );

        $expectedPayload = [
            'userId' => $userId,
        ];

        self::assertEquals($expectedPayload, $event->toPayload());
    }
}
