<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity;

final class FirstName
{
    private $value;

    public function __construct(string $value)
    {
        if (\strlen($value) < 2) {
            throw new \InvalidArgumentException('First name is too short.');
        }

        $this->value = $value;
    }

    public static function fromString(string $firstName): FirstName
    {
        return new self($firstName);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(FirstName $firstName): bool
    {
        return $this->value === $firstName->value;
    }
}
