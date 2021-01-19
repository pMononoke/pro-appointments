<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service;

use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;

interface PasswordEncoder
{
    public function encode(object $user, string $plainPassword): UserPassword;
}
