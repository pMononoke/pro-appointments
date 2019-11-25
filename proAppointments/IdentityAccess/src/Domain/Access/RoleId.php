<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Access;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class RoleId
{
    private $uuid;

    public static function generate(): RoleId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $roleId): RoleId
    {
        return new self(Uuid::fromString($roleId));
    }

    private function __construct(UuidInterface $roleId)
    {
        $this->uuid = $roleId;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(RoleId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
