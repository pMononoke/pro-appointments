<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service;

use ProAppointments\IdentityAccess\Domain\User\UserPassword;

interface PasswordEncoder
{
    public function encode(object $plainPassword): UserPassword;
}
