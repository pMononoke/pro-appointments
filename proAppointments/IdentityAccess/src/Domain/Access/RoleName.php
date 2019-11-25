<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Access;

final class RoleName
{
    private $value;

    public function __construct(string $value)
    {
        if (strlen($value) < 8) {
            throw new \InvalidArgumentException('Role name too short.');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function fromString(string $roleName): RoleName
    {
        return new self($roleName);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(RoleName $roleName): bool
    {
        return $this->value === $roleName->value;
    }
}
