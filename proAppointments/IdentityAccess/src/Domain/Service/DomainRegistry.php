<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service;

interface DomainRegistry
{
    public static function clockService();

    public static function userRepository();
}
