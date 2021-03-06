<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Notification;

interface PublishedMessageTracker
{
//    /**
//     * @param $aTypeName
//     *
//     * @return int
//     */
    public function mostRecentPublishedMessageId($aTypeName);

//    /**
//     * @param $aTypeName
//     * @param StoredEvent $notification
//     */
    public function trackMostRecentPublishedMessage($aTypeName, $notification);
}
