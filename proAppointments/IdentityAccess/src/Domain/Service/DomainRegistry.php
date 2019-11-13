<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service;

interface DomainRegistry
{
    public static function clockSystemService();

    public static function userRepository();
}
