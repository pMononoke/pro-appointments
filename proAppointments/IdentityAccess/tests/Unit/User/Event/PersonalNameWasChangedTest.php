<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User\Event;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\Event\PersonalNameWasChanged;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\LastName;
use ProAppointments\IdentityAccess\Domain\User\UserId;

class PersonalNameWasChangedTest extends TestCase
{
    /** @test */
    public function can_be_created(): void
    {
        $event = new PersonalNameWasChanged(
            $userId = UserId::generate(),
            $firstName = FirstName::fromString('irrelevant firstname'),
            $lastName = LastName::fromString('irrelevant lastname')
        );

        self::assertEquals($userId, $event->userId());
        self::assertEquals($firstName, $event->firstName());
        self::assertEquals($lastName, $event->lastName());
        self::assertNotNull($event->occurredOn());
    }

    /** @test */
    public function can_return_the_payload(): void
    {
        $event = new PersonalNameWasChanged(
            $userId = UserId::generate(),
            $firstName = FirstName::fromString('irrelevant firstname'),
            $lastName = LastName::fromString('irrelevant lastname')
        );

        $expectedPayload = [
            'userId' => $userId->toString(),
            'firstName' => $firstName->toString(),
            'lastName' => $lastName->toString(),
        ];

        self::assertEquals($expectedPayload, $event->toPayload());
    }
}
