<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Application\Service\Query\UsersQuery;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUsersQuery;
use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryUsersQueryTest extends KernelTestCase
{
    use UserFixtureBehavior;

    private const TABLES = ['ia_user', 'ia_person'];

    /** @var UsersQuery */
    private $usersQuery;

    /** @var RoleRepository */
    private $repository;

    protected function setUp()
    {
        $this->repository = new InMemoryUserRepository();

        $this->usersQuery = new InMemoryUsersQuery(
            $this->repository
        );
    }

    /** @test */
    public function can_find_all_users(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->pupulateDatabase($user);

        list($id, $user2) = $this->generateUserAggregate();
        $this->pupulateDatabase($user2);
        list($id, $user3) = $this->generateUserAggregate();
        $this->pupulateDatabase($user3);
        list($id, $user4) = $this->generateUserAggregate();
        $this->pupulateDatabase($user4);

        $allUsersFromDatabase = $this->usersQuery->execute();

        $this->assertEquals(4, count($allUsersFromDatabase));
    }

    /** @test */
    public function querying_all_users_return_emty_list(): void
    {
        $allUsersFromDatabase = $this->usersQuery->execute();
        $this->assertEquals(0, count($allUsersFromDatabase));
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
        $this->usersQuery = null;
        parent::tearDown();
    }
}
