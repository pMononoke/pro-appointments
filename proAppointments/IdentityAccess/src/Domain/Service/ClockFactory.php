<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service;

interface ClockFactory
{
    public function createOccurredOnForEvent(): \DateTimeImmutable;
}
