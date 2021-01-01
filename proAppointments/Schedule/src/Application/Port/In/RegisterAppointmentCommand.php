<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application\Port\In;

use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

final class RegisterAppointmentCommand
{
    /** @var AppointmentId */
    private $appointmentId;

    public function __construct(AppointmentId $appointmentId)
    {
        $this->appointmentId = $appointmentId;
    }

    // todo
//    public static function with(AppointmentId $appointmentId): void
//    {
//        $this->appointmentId = $appointmentId;
//    }

    public function registerAppointmentCommand(AppointmentId $appointmentId): void
    {
        $this->appointmentId = $appointmentId;
    }

    public function appointmentId(): AppointmentId
    {
        return $this->appointmentId;
    }
}
