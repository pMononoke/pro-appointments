<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Tests\Unit\Appointment;

use PHPUnit\Framework\TestCase;
use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

class AppointmentIdTest extends TestCase
{
    private const UUID = '100ade38-ad18-4cf4-9ac5-de2b00c4abb7';

    /** @test */
    public function can_autogenerate_a_appointmentId_object(): void
    {
        self::assertInstanceOf(AppointmentId::class, AppointmentId::generate());
    }

    /** @test */
    public function can_be_created_from_string(): void
    {
        $userId = AppointmentId::fromString(self::UUID);

        self::assertEquals(self::UUID, $userId->toString());
        self::assertEquals(self::UUID, $userId->__toString());
    }

    /** @test */
    public function can_be_compared(): void
    {
        $first = AppointmentId::fromString(self::UUID);
        $second = AppointmentId::generate();
        $copyOfFirst = AppointmentId::fromString(self::UUID);

        self::assertFalse($first->equals($second));
        self::assertTrue($first->equals($copyOfFirst));
        self::assertFalse($second->equals($copyOfFirst));
    }
}
