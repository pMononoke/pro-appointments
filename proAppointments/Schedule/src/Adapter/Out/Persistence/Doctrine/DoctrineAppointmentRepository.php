<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Adapter\Out\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use ProAppointments\Schedule\Application\Port\Out\LoadAppointmentPort;
use ProAppointments\Schedule\Application\Port\Out\RegisterAppointmentPort;
use ProAppointments\Schedule\Application\Port\Out\UpdateAppointmentStatePort;
use ProAppointments\Schedule\Domain\Appointment\Appointment;
use ProAppointments\Schedule\Domain\Appointment\AppointmentId;

/**
 * Class DoctrineAppointmentRepository.
 *
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 */
class DoctrineAppointmentRepository extends ServiceEntityRepository implements UpdateAppointmentStatePort, LoadAppointmentPort, RegisterAppointmentPort
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointment::class);
    }

    public function updateAppointmentState(Appointment $appointment)
    {
        // TODO: Implement updateAppointmentState() method.
        $this->_em->persist($appointment);
        // TODO IS transational same as register
        $this->_em->flush($appointment);
    }

    public function loadAppointment(AppointmentId $appointmentId)
    {
        // TODO: Implement loadAppointment() method.
        return $this->find($appointmentId);
    }

    public function registerAppointment(Appointment $appointment)
    {
        // TODO: Implement registerAppointment() method.
        $this->_em->persist($appointment);
        $this->_em->flush();
    }
}
