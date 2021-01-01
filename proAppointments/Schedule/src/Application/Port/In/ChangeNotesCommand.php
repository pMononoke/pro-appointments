<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application\Port\In;

use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

final class ChangeNotesCommand
{
    /** @var AppointmentId */
    private $appointmentId;

    /** @var string */
    private $notes;

    public function registerAppointmentCommand(AppointmentId $appointmentId, string $notes): void
    {
        $this->appointmentId = $appointmentId;
        $this->notes = $notes;
    }

    public function appointmentId(): AppointmentId
    {
        return $this->appointmentId;
    }

    public function notes(): string
    {
        return $this->notes;
    }
}
