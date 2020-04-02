<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Tests\Unit\Command;

use PHPUnit\Framework\TestCase;
use ProAppointments\Schedule\Application\Port\In\RegisterAppointmentCommand;
use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

class RegisterAppointmentCommandTest extends TestCase
{
    private const UUID = '100ade38-ad18-4cf4-9ac5-de2b00c4abb7';

    /** @test */
    public function can_be_created(): void
    {
        $command = new RegisterAppointmentCommand($id = AppointmentId::fromString(self::UUID));

        self::assertEquals($id, $command->appointmentId());
    }
}
