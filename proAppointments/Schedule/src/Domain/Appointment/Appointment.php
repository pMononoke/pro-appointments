<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Domain\Appointment;

class Appointment implements AppointmentInterface
{
    /** @var AppointmentId */
    private $id;

    /** @var string */
    private $notes;

    /**
     * Appointment constructor.
     */
    public function __construct(AppointmentId $id)
    {
        $this->id = $id;
    }

    public static function register(AppointmentId $id): self
    {
        $appointment = new self($id);

        return $appointment;
    }

    public function id(): AppointmentId
    {
        return $this->id;
    }

    public function notes(): string
    {
        return $this->notes;
    }

    public function addNotes(string $notes): void
    {
        $this->notes = $notes;
    }
}
