<?php

namespace ProAppointments\IdentityAccess\Infrastructure\DomainService;

use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;
use ProAppointments\IdentityAccess\Domain\Service\DomainRegistry as DomainRegistryPort;
use ProAppointments\IdentityAccess\Domain\Service\PasswordEncoder;
use ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmailInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DomainRegistry implements DomainRegistryPort
{
    /**
     * @var ContainerInterface
     */
    private static $container;

    public static function clockSystemService()
    {
        return static::$container->get('app.clock.system');
    }

    public static function userRepository(): UserRepository
    {
        return static::$container->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter');
    }

    public static function passwordEncoder(): PasswordEncoder
    {
        return new NullPasswordEncoder();
    }

    public static function uniqueUserEmail(): UniqueUserEmailInterface
    {
        return static::$container->get('ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmail');
    }

    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }
}
