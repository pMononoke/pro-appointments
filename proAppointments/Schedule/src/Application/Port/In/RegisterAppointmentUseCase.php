<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application\Port\In;

interface RegisterAppointmentUseCase
{
    public function registerAppointment(RegisterAppointmentCommand $command);
}
