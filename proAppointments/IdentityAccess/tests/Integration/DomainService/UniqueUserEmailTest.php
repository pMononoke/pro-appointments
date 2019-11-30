<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\DomainService;

use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;
use ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmail;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUniqueUserEmailQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UniqueUserEmailTest extends kernelTestCase
{
    use UserFixtureBehavior;

    /** @var UniqueUserEmail */
    private $uniqueUserEmailService;

    /** @var UserRepository */
    private $userRepository;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->uniqueUserEmailService = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmail');
        $this->userRepository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter');
    }

    /** @test */
    public function a_UserEmail_is_unique_if_user_email_not_exist_in_the_system(): void
    {
        self::assertTrue(($this->uniqueUserEmailService)(UserEmail::fromString('unknown@example.com')));
    }

    /** @test */
    public function a_UserEmail_is_not_unique_if_user_email_exist_in_the_system(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->userRepository->register($user);

        self::assertFalse(($this->uniqueUserEmailService)(UserEmail::fromString('irrelevant@email.com')));
    }

    /** @test */
    public function IN_MEMORY_a_UserEmail_is_unique_if_user_email_not_exist_in_the_system(): void
    {
        $query = new InMemoryUniqueUserEmailQuery($userRepository = new InMemoryUserRepository());
        $uniqueUserEmailService = new UniqueUserEmail($query);

        self::assertTrue(($uniqueUserEmailService)(UserEmail::fromString('unknown@example.com')));
    }

    /** @test */
    public function IN_MEMORY_VERSION_a_UserEmail_is_not_unique_if_user_email_exist_in_the_system(): void
    {
        $query = new InMemoryUniqueUserEmailQuery($userRepository = new InMemoryUserRepository());
        $uniqueUserEmailService = new UniqueUserEmail($query);

        list($id, $user) = $this->generateUserAggregate();
        $userRepository->register($user);

        self::assertFalse(($uniqueUserEmailService)(UserEmail::fromString('irrelevant@email.com')));
    }

    protected function tearDown()
    {
        $this->uniqueUserEmailService = null;
        $this->userRepository = null;
    }
}
