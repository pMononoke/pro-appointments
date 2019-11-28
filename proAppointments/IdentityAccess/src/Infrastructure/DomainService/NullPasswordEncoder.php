<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\DomainService;

use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Domain\Service\PasswordEncoder;

class NullPasswordEncoder implements PasswordEncoder
{
    public function encode(object $plainPassword): UserPassword
    {
    }
}
