<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application;

use ProAppointments\Schedule\Application\Port\In\RegisterAppointmentCommand;
use ProAppointments\Schedule\Application\Port\In\RegisterAppointmentUseCase;
use ProAppointments\Schedule\Application\Port\Out\RegisterAppointmentPort;
use ProAppointments\Schedule\Domain\Appointment\Appointment;

class RegisterAppointmentService implements RegisterAppointmentUseCase
{
    /** @var RegisterAppointmentPort */
    private $repository;

    /**
     * RegisterAppointmentService constructor.
     */
    public function __construct(RegisterAppointmentPort $repository)
    {
        $this->repository = $repository;
    }

    public function registerAppointment(RegisterAppointmentCommand $command): bool
    {
        // TODO: Implement registerAppointment() method.

        // TODO: validate business rules
        // TODO: manipulate model state
        // TODO: return output

        $appointment = Appointment::register($command->appointmentId());

        $this->repository->registerAppointment($appointment);

        return true;
    }
}
