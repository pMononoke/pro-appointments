<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity;

final class MobileNumber
{
    private $mobileNumber;

    private function __construct(string $mobileNumber)
    {
        $this->mobileNumber = $mobileNumber;
    }

    public static function asUnknown(): MobileNumber
    {
        return new self('');
    }

    public function withMobileNumber(string $mobileNumber): MobileNumber
    {
        return self::fromString($mobileNumber);
    }

    public static function fromString(string $mobileNumber): MobileNumber
    {
        if (\strlen($mobileNumber) < 5) {
            throw new \InvalidArgumentException('Telephone number may not be less than 5 characters.');
        }

        if (\strlen($mobileNumber) > 20) {
            throw new \InvalidArgumentException('Telephone number may not be more than 20 characters.');
        }

        return new self($mobileNumber);
    }

    public function toString(): string
    {
        return $this->mobileNumber;
    }

    public function __toString(): string
    {
        return $this->mobileNumber;
    }

    public function equals(MobileNumber $mobileNumber): bool
    {
        return $this->mobileNumber === $mobileNumber->mobileNumber;
    }
}
