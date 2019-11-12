<?php

namespace ProAppointments\IdentityAccess\Infrastructure\DomainService;

use ProAppointments\IdentityAccess\Domain\Service\DomainRegistry as DomainRegistryPort;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DomainRegistry implements DomainRegistryPort
{
    /**
     * @var ContainerInterface
     */
    private static $container;

    public static function clockService()
    {
        // TODO: Implement clockService() method.
    }

    public static function userRepository()
    {
        return static::$container->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter');
    }

    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }
}
