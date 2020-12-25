<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Domain\Appointment;

final class AppointmentId
{
    /** @var \Ramsey\Uuid\UuidInterface */
    private $uuid;

    public static function generate(): AppointmentId
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4());
    }

    public static function fromString(string $appointmentId): AppointmentId
    {
        return new self(\Ramsey\Uuid\Uuid::fromString($appointmentId));
    }

    private function __construct(\Ramsey\Uuid\UuidInterface $appointmentId)
    {
        $this->uuid = $appointmentId;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(AppointmentId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
