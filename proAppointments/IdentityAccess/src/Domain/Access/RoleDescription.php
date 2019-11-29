<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Access;

final class RoleDescription
{
    private $value;

    public function __construct(string $value)
    {
        if (strlen($value) < 10) {
            throw new \InvalidArgumentException('Role description is too short.');
        }

        $this->value = $value;
    }

    public static function fromString(string $roleDescription): RoleDescription
    {
        return new self($roleDescription);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(RoleDescription $roleDescription): bool
    {
        return $this->value === $roleDescription->value;
    }
}
