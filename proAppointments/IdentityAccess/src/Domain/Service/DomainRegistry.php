<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service;

use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;

interface DomainRegistry
{
    public static function clockSystemService();

    public static function userRepository(): UserRepository;

    public static function passwordEncoder(): PasswordEncoder;
}
