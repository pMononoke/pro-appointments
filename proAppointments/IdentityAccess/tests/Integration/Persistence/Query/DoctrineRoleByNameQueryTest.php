<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\RoleByNameQuery;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineRoleByNameQueryTest extends KernelTestCase
{
    use RoleFixtureBehavior;

    private const TABLES = ['ia_role'];

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
        $userFromQuery = $this->roleQuery->execute(RoleName::fromString('irrelevant'));

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

    protected function tearDown()
    {
        $this->repository = null;
        $this->roleQuery = null;
        parent::tearDown();
    }
}
