<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application;

use ProAppointments\Schedule\Application\Port\In\GetAccountBalanceQuery;
use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

final class GetAccountBalanceService implements GetAccountBalanceQuery
{
    public function getAccountBalance(AppointmentId $appointmentId)
    {
        // TODO: Implement getAccountBalance() method.

        // TODO: validate business rules
        // TODO: query the persistance layer
        // TODO: return output
    }
}
