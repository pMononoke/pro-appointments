<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Tests\Unit\Appointment;

use PHPUnit\Framework\TestCase;
use ProAppointments\Schedule\Domain\Appointment\Appointment;
use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

class AppointmentTest extends TestCase
{
    /** @test */
    public function can_be_created(): void
    {
        $id = AppointmentId::generate();

        $appointment = Appointment::register($id);

        self::assertInstanceOf(Appointment::class, $appointment);
        self::assertSame($id, $appointment->id());
    }

    /** @test */
    public function can_add_a_notes(): void
    {
        $appointment = Appointment::register(AppointmentId::generate());
        $appointment->addNotes('irrelevant');

        self::assertSame('irrelevant', $appointment->notes());
    }
}
