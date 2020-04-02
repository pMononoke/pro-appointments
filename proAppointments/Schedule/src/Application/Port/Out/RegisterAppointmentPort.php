<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application\Port\Out;

use ProAppointments\Schedule\Domain\Appointment\Appointment;

interface RegisterAppointmentPort
{
    public function registerAppointment(Appointment $appointment);
}
