<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application;

use ProAppointments\Schedule\Application\Port\In\ChangeNotesCommand;
use ProAppointments\Schedule\Application\Port\In\ChangeNotesUseCase;
use ProAppointments\Schedule\Application\Port\Out\LoadAppointmentPort;
use ProAppointments\Schedule\Application\Port\Out\UpdateAppointmentStatePort;
use ProAppointments\Schedule\Domain\Appointment\Appointment;
use ProAppointments\Schedule\Domain\Appointment\AppointmentRepository;

class ChangeNotesService implements ChangeNotesUseCase
{
    /** @var LoadAppointmentPort */
    private $appointmentloader;

    /** @var UpdateAppointmentStatePort */
    private $repository;

    public function __construct(UpdateAppointmentStatePort $repository, LoadAppointmentPort $appointmentloader)
    {
        $this->repository = $repository;
        $this->appointmentloader = $appointmentloader;
    }

    public function ChangeNotes(ChangeNotesCommand $command)
    {
        // TODO: Implement ChangeNotes() method.
        // TODO: validate business rules
        // TODO: manipulate model state
        // TODO: return output

        /** @var Appointment $appointment */
        $appointment = $this->appointmentloader->loadAppointment($command->appointmentId());

        $appointment->addNotes($command->notes());

        $this->repository->updateAppointmentState($appointment);
    }
}
