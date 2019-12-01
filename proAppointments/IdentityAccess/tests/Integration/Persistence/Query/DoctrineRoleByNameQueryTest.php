<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleNameQuery;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineRoleByNameQueryTest extends KernelTestCase
{
    use RoleFixtureBehavior;

    /** @var UniqueRoleNameQuery */
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
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query\UniqueRoleNameQuery');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');
    }

    /** @test */
    public function can_return_not_unique_role_name_if_role_name_exist(): void
    {
        $role = $this->generateRoleAggregate();
        $this->pupulateDatabase($role);

        $this->assertFalse($this->roleQuery->execute($role->name()));
    }

    /** @test */
    public function can_return_unique_role_name_if_role_name_not_exist(): void
    {
        $this->assertTrue($this->roleQuery->execute(RoleName::fromString('unknown-role-name')));
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
