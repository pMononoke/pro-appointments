<?php

namespace ProAppointments\IdentityAccess\Infrastructure\Notification;

//use Ddd\Domain\DomainEvent;

class StoredEvent //implements DomainEvent
{
    /**
     * @var int
     */
    private $eventId;

    /**
     * @var string
     */
    private $eventBody;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    /**
     * @var string
     */
    private $typeName;

    /**
     * @param string             $aTypeName
     * @param \DateTimeImmutable $anOccurredOn
     * @param string             $anEventBody
     */
    public function __construct($aTypeName, \DateTimeImmutable $anOccurredOn, string $anEventBody)
    {
        $this->eventBody = $anEventBody;
        $this->typeName = $aTypeName;
        $this->occurredOn = $anOccurredOn;
    }

    /**
     * @return string
     */
    public function eventBody()
    {
        return $this->eventBody;
    }

    /**
     * @return int
     */
    public function eventId()
    {
        return $this->eventId;
    }

    /**
     * @return string
     */
    public function typeName()
    {
        return $this->typeName;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
