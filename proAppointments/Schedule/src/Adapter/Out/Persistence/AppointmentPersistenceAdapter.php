<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Adapter\Out\Persistence;

use ProAppointments\Schedule\Adapter\Out\Persistence\Doctrine\DoctrineAppointmentRepository;
use ProAppointments\Schedule\Application\Port\Out\LoadAppointmentPort;
use ProAppointments\Schedule\Application\Port\Out\RegisterAppointmentPort;
use ProAppointments\Schedule\Application\Port\Out\UpdateAppointmentStatePort;
use ProAppointments\Schedule\Domain\Appointment\Appointment;
use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

class AppointmentPersistenceAdapter implements UpdateAppointmentStatePort, LoadAppointmentPort, RegisterAppointmentPort
{
    /** @var DoctrineAppointmentRepository */
    private $innerStorage;

    /**
     * AppointmentPersistenceAdapter constructor.
     *
     * @param mixed $innerStorage
     */
    public function __construct($innerStorage)
    {
        // TODO VALIDATE IS NOT NULL AND ACCEPTED TYPE
        $this->innerStorage = $innerStorage;
    }

    public function loadAppointment(AppointmentId $appointmentId)
    {
        $this->innerStorage->loadAppointment($appointmentId);
    }

    public function registerAppointment(Appointment $appointment)
    {
        $this->innerStorage->registerAppointment($appointment);
    }

    public function updateAppointmentState(Appointment $appointment)
    {
        $this->innerStorage->updateAppointmentState($appointment);
    }
}
