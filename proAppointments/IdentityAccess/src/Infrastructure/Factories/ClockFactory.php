<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Factories;

use CompostDDD\Time\Clock;
use ProAppointments\IdentityAccess\Domain\Service\ClockFactory as ClockFactoryPort;

class ClockFactory implements ClockFactoryPort
{
    /** @var Clock */
    private $systemClock;

    /**
     * ClockFactory constructor.
     */
    public function __construct(Clock $systemClock)
    {
        $this->systemClock = $systemClock;
    }

    public function createOccurredOnForEvent(): \DateTimeImmutable
    {
        return $this->systemClock();
    }

    private function systemClock(): \DateTimeImmutable
    {
        return $this->systemClock->dateTime();
    }
}
