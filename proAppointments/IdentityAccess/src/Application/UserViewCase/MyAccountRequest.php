<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserViewCase;

use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class MyAccountRequest
{
    /** @var UserId */
    private $issuer;

    /**
     * MyAccountRequest constructor.
     */
    public function __construct(string $issuer)
    {
        $this->issuer = UserId::fromString($issuer);
    }

    public function issuer(): UserId
    {
        return $this->issuer;
    }
}
