<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Notification;

class NullEventStore implements EventStore
{
    public function append($aDomainEvent)
    {
    }

    public function allStoredEventsSince($anEventId)
    {
    }
}
