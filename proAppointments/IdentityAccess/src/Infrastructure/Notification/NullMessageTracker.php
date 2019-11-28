<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Notification;

class NullMessageTracker implements PublishedMessageTracker
{
    public function mostRecentPublishedMessageId($aTypeName)
    {
    }

    public function trackMostRecentPublishedMessage($aTypeName, $notification)
    {
    }
}
