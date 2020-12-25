<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application\Port\In;

use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

interface GetAccountBalanceQuery
{
    public function getAccountBalance(AppointmentId $appointmentId);
}
