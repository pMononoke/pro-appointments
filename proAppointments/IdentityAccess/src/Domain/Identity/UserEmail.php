<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity;

final class UserEmail
{
    private $value;

    public function __construct(string $value)
    {
        if (\strlen($value) < 5) {
            throw new \InvalidArgumentException('User email is too short.');
        }

        $this->value = $value;
    }

    public static function fromString(string $userEmail): UserEmail
    {
        return new self($userEmail);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(UserEmail $userEmail): bool
    {
        return $this->value === $userEmail->value;
    }
}
