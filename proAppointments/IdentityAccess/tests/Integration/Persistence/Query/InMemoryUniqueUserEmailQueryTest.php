<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmailQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InfrastructureUserRepository;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUniqueUserEmailQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryUniqueUserEmailQueryTest extends KernelTestCase
{
    use UserFixtureBehavior;

    /** @var uniqueUserEmailQuery */
    private $uniqueUserEmailQuery;

    /** @var InfrastructureUserRepository */
    private $repository;

    protected function setUp()
    {
        $this->repository = new InMemoryUserRepository();

        $this->uniqueUserEmailQuery = new InMemoryUniqueUserEmailQuery($this->repository);
    }

    /** @test */
    public function can_return_not_unique_email_if_email_exist(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->pupulateDatabase($user);

        $this->assertFalse($this->uniqueUserEmailQuery->execute($user->email()));
    }

    /** @test */
    public function can_return_unique_email_if_email_not_exist(): void
    {
        $this->assertTrue($this->uniqueUserEmailQuery->execute(UserEmail::fromString('unknown@example.com')));
    }

    private function pupulateDatabase(object $data): void
    {
        $this->writeData($data);
    }

    protected function writeData(object $data): void
    {
        $this->repository->register($data);
    }

    protected function tearDown()
    {
        $this->repository = null;
        $this->uniqueUserEmailQuery = null;
        parent::tearDown();
    }
}
