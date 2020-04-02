<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Tests\Functional\Persistence\DoctrineRepository;

use ProAppointments\Schedule\Adapter\Out\Persistence\Doctrine\DoctrineAppointmentRepository;
use ProAppointments\Schedule\Domain\Appointment\Appointment;
use ProAppointments\Schedule\Domain\Appointment\AppointmentId;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineAppointmentRepositoryTest extends KernelTestCase
{
    /** @var DoctrineAppointmentRepository|null */
    private $appointmentRepository;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->appointmentRepository = $kernel->getContainer()
            ->get('ProAppointments\Schedule\Adapter\Out\Persistence\Doctrine\DoctrineAppointmentRepository');
    }

    /** @test */
    public function can_register_and_retrieve_an_appointment(): void
    {
        $appointment = Appointment::register($id = AppointmentId::generate());
        $appointment->addNotes('irrelevant');

        $this->appointmentRepository->registerAppointment($appointment);

        $appointmentFromDatabase = $this->appointmentRepository->find($id);
        self::assertEquals($id, $appointmentFromDatabase->id());
        self::assertEquals('irrelevant', $appointmentFromDatabase->notes());
    }

    /** @test */
    public function can_update_and_retrieve_an_appointment(): void
    {
        $appointment = Appointment::register($id = AppointmentId::generate());
        $appointment->addNotes('irrelevant');
        $this->appointmentRepository->registerAppointment($appointment);

        $appointment->addNotes('new value');
        $this->appointmentRepository->updateAppointmentState($appointment);

        $appointmentFromDatabase = $this->appointmentRepository->find($id);
        self::assertEquals('new value', $appointmentFromDatabase->notes());
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->appointmentRepository = null;
    }
}
