<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

final class UserPassword
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $userPassword): UserPassword
    {
        return new self($userPassword);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(UserPassword $userPassword): bool
    {
        return $this->value === $userPassword->value;
    }
}
