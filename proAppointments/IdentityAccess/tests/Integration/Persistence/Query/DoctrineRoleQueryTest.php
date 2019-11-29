<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Application\Service\Query\RoleQuery;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineRoleQueryTest extends KernelTestCase
{
    use RoleFixtureBehavior;

    private const TABLES = ['ia_role'];

    /** @var RoleQuery */
    private $roleQuery;

    /** @var RoleRepository */
    private $repository;

    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->repository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineRoleRepository');

        $this->roleQuery = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query\RoleQuery');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');
    }

    /** @test */
    public function can_find_a_role_by_role_id(): void
    {
        $role = $this->generateRoleAggregate();
        $this->pupulateDatabase($role);

        $userFromQuery = $this->roleQuery->execute($role->id());

        self::assertTrue($role->sameIdentityAs($userFromQuery));
        self::assertTrue($role->name()->equals($userFromQuery->name()));
        self::assertTrue($role->description()->equals($userFromQuery->description()));
    }

    /** @test */
    public function querying_by_role_id_return_a_null_value(): void
    {
        $userFromQuery = $this->roleQuery->execute(RoleId::generate());

        self::assertNull($userFromQuery);
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

    private function clearDatabase(): void
    {
        $this->truncateTables();
    }

    private function truncateTables(): void
    {
        $this->entityManager->getConnection()->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        foreach (self::TABLES as $table) {
            $this->entityManager->getConnection()->executeQuery(sprintf('TRUNCATE `%s`;', $table));
        }
        $this->entityManager->getConnection()->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
    }

    protected function tearDown()
    {
        $this->clearDatabase();
        $this->repository = null;
        $this->roleQuery = null;
        parent::tearDown();
    }
}
