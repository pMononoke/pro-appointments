<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity;

final class LastName
{
    private $value;

    public function __construct(string $value)
    {
        if (\strlen($value) < 2) {
            throw new \InvalidArgumentException('Last name is too short.');
        }

        $this->value = $value;
    }

    public static function fromString(string $lastName): LastName
    {
        return new self($lastName);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(LastName $lastName): bool
    {
        return $this->value === $lastName->value;
    }
}
