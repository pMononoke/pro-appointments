<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleDescription;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\RoleByNameQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleByNameQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleCollection;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineRoleByNameQueryTest extends KernelTestCase
{
    private const TABLES = ['ia_role'];

    private const ROLE_NAME = 'irrelevant';
    private const ROLE_DESCRIPTION = 'irrelevant';

    /** @var RoleByNameQuery */
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
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query\RoleByNameQuery');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');

//        $this->repository = new InMemoryRoleRepository();
//
//        $this->roleQuery = new InMemoryRoleByNameQuery(
//            new InMemoryRoleCollection($this->repository)
//        );
    }

    /** @test */
    public function can_find_a_role_by_roleName(): void
    {
        $role = $this->generateRoleAggregate();
        $this->pupulateDatabase($role);

        $userFromQuery = $this->roleQuery->execute($role->name());

        self::assertTrue($role->name()->equals($userFromQuery->name()));
        self::assertTrue($role->name()->equals($userFromQuery->name()));
        self::assertTrue($role->description()->equals($userFromQuery->description()));
    }

    /** @test */
    public function query_by_RoleName_return_a_null_value(): void
    {
        $userFromQuery = $this->roleQuery->execute(RoleName::fromString(self::ROLE_NAME));

        self::assertNull($userFromQuery);
    }

    protected function generateRoleAggregate(): Role
    {
        $id = RoleId::generate();
        $name = RoleName::fromString(self::ROLE_NAME);
        $description = RoleDescription::fromString(self::ROLE_DESCRIPTION);
        $role = new Role($id, $name, $description);

        return $role;
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
