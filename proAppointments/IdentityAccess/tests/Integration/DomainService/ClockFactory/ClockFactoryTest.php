<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\DomainService\ClockFactory;

use CompostDDD\Time\TestClock;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Infrastructure\Factories\ClockFactory;

class ClockFactoryTest extends TestCase
{
    private const FIXED_DATE_TIME = '1947-01-01 00:00:00';

    /** @test */
    public function can_create_date_for_event_object(): void
    {
        $clock = new TestClock($timezone = new DateTimeZone('UTC'));
        $clock->fixate(self::FIXED_DATE_TIME);
        $date = $clock->dateTime();
        $clockFactory = new ClockFactory($clock);

        $dateFromFactory = $clockFactory->createOccurredOnForEvent();

        self::assertInstanceOf(\DateTimeImmutable::class, $date);
        self::assertEquals($timezone, $dateFromFactory->getTimezone());
        self::assertEquals($date, $dateFromFactory);
    }
}
