<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Notification;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Infrastructure\Notification\StoredEvent;

class StoredEventTest extends TestCase
{
    /** @test */
    public function can_be_created(): void
    {
        $storedEvent = new StoredEvent($typeName = 'aTypeName', $occurredOn = new \DateTimeImmutable('now'), $eventBody = 'aEventBody');

        self::assertEquals($typeName, $storedEvent->typeName());
        self::assertEquals($occurredOn, $storedEvent->occurredOn());
        self::assertEquals($eventBody, $storedEvent->eventBody());
    }
}
