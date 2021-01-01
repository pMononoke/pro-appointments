<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application\Port\Out;

use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

interface LoadAppointmentPort
{
    public function loadAppointment(AppointmentId $appointmentId);
}
