<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\DomainService;

use ProAppointments\IdentityAccess\Domain\Service\PasswordEncoder;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

class NullPasswordEncoder implements PasswordEncoder
{
    public function encode(object $plainPassword): UserPassword
    {
    }
}
