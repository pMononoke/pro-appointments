<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\DomainService;

use ProAppointments\IdentityAccess\Domain\Service\DomainRegistry;
use ProAppointments\IdentityAccess\Domain\User\UserRepository;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DomainRegistryTest extends KernelTestCase
{
    /** @var DomainRegistry */
    private $domainRegistry;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->domainRegistry = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\DomainService\DomainRegistry');
    }

    /** @test */
    public function can_provide_the_ClockService(): void
    {
        self::markTestSkipped('IMPLEMENTARE !!!');
    }

    /** @test */
    public function can_provide_the_UserRepository(): void
    {
        $userRepository = $this->domainRegistry->userRepository();

        self::assertInstanceOf(UserRepository::class, $userRepository);
        self::assertInstanceOf(UserRepositoryAdapter::class, $userRepository);
    }
}
