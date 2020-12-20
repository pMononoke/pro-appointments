<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group doctrine
 */
class DoctrineUsersQueryTest extends KernelTestCase
{
    use UserFixtureBehavior;

    private $userQuery;

    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->userQuery = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query\UsersQuery');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');
    }

    /** @test */
    public function can_find_all_users(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->pupulateDatabase($user);
        list($id2, $user2) = $this->generateUserAggregate();
        $this->pupulateDatabase($user2);
        list($id3, $user3) = $this->generateUserAggregate();
        $this->pupulateDatabase($user3);

        $allUsersFromDatabase = $this->userQuery->execute();

        $this->assertEquals(3, \count($allUsersFromDatabase));
    }

    /** @test */
    public function can_find_all_users_with_Limit_parameter(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->writeData($user);
        list($id2, $user2) = $this->generateUserAggregate();
        $this->writeData($user2);
        list($id3, $user3) = $this->generateUserAggregate();
        $this->writeData($user3);

        $allUsersFromDatabase = $this->userQuery->execute(2);

        $this->assertEquals(2, \count($allUsersFromDatabase));
    }

    private function pupulateDatabase(object $data): void
    {
        $this->writeData($data);
    }

    protected function writeData(object $data): void
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    protected function tearDown()
    {
        $this->userQuery = null;
        parent::tearDown();
    }
}
