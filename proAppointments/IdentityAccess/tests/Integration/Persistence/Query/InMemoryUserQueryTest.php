<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Application\Service\Query\UserQuery;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InfrastructureRoleRepository;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUserQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryUserQueryTest extends KernelTestCase
{
    use UserFixtureBehavior;

    private const TABLES = ['ia_user', 'ia_person'];

    /** @var UserQuery */
    private $userQuery;

    /** @var InfrastructureRoleRepository */
    private $repository;

    protected function setUp()
    {
        $this->repository = new InMemoryUserRepository();

        $this->userQuery = new InMemoryUserQuery(
            $this->repository
        );
    }

    /** @test */
    public function can_find_a_user_by_user_id(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->pupulateDatabase($user);

        $userFromDatabase = $this->userQuery->execute($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
    }

    /** @test */
    public function querying_by_user_id_return_a_null_value(): void
    {
        $userFromQuery = $this->userQuery->execute(UserId::generate());

        self::assertNull($userFromQuery);
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
        $this->userQuery = null;
        parent::tearDown();
    }
}
