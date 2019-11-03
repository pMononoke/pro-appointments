<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\HumbleRepository;

use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\FullName;
use ProAppointments\IdentityAccess\Domain\User\LastName;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

class HumbleUser extends User
{
    /**
     * HumbleUser constructor.
     */
    public function __construct()
    {
        parent::register(
            UserId::generate(),
            UserEmail::fromString('humble@example.com'),
            UserPassword::fromString('humble-password'),
            new FullName(
                FirstName::fromString('humble-first-name'),
                LastName::fromString('humble-last-name')
            )
        );
    }
}
