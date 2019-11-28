<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserId
{
    private $uuid;

    public static function generate(): UserId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $userId): UserId
    {
        return new self(Uuid::fromString($userId));
    }

    private function __construct(UuidInterface $userId)
    {
        $this->uuid = $userId;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(UserId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
