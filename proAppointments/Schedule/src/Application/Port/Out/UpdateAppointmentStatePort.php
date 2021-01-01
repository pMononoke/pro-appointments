<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application\Port\Out;

use ProAppointments\Schedule\Domain\Appointment\Appointment;

interface UpdateAppointmentStatePort
{
    public function updateAppointmentState(Appointment $appointment);
}
