<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service;

use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleNameInterface;
use ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmailInterface;

interface DomainRegistry
{
    public static function clockSystemService();

    public static function userRepository(): UserRepository;

    public static function passwordEncoder(): PasswordEncoder;

    public static function uniqueUserEmail(): UniqueUserEmailInterface;

    public static function uniqueRoleName(): UniqueRoleNameInterface;
}
