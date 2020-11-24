<?php

namespace ProAppointments\IdentityAccess\Infrastructure\Notification;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

//use Doctrine\Common\Persistence\ManagerRegistry;

class DoctrineEventStore extends ServiceEntityRepository implements EventStore
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoredEvent::class);
    }

    public function append($aDomainEvent)
    {
        $storedEvent = new StoredEvent(
            (string) get_class($aDomainEvent),
            $aDomainEvent->occurredOn(),
            // TODO ->toPayload() return event_body + event_metadata
            (string) json_encode($aDomainEvent->toPayload())
        );

        $this->_em->persist($storedEvent);
        $this->_em->flush($storedEvent);
    }

    public function allStoredEventsSince($anEventId)
    {
        $query = $this->createQueryBuilder('e');
        if ($anEventId) {
            $query->where('e.eventId > :eventId');
            $query->setParameters(['eventId' => $anEventId]);
        }
        $query->orderBy('e.eventId');

        return $query->getQuery()->getResult();
    }
}
