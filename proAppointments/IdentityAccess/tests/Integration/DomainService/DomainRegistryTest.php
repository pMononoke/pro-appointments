<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\DomainService;

use CompostDDD\Time\Clock;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;
use ProAppointments\IdentityAccess\Domain\Service\DomainRegistry;
use ProAppointments\IdentityAccess\Domain\Service\PasswordEncoder;
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
    public function can_provide_a_ClockSystemService(): void
    {
        $clockSystemService = $this->domainRegistry->clockSystemService();

        self::assertInstanceOf(Clock::class, $clockSystemService);
    }

    /** @test */
    public function can_provide_a_UserRepository(): void
    {
        $userRepository = $this->domainRegistry->userRepository();

        self::assertInstanceOf(UserRepository::class, $userRepository);
        self::assertInstanceOf(UserRepositoryAdapter::class, $userRepository);
    }

    /** @test */
    public function can_provide_a_PasswordEncoder(): void
    {
        $passwordEncoder = $this->domainRegistry->passwordEncoder();

        self::assertInstanceOf(PasswordEncoder::class, $passwordEncoder);
    }
}
