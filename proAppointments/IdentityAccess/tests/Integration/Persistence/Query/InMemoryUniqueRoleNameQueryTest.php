<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleNameQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleRepository;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUniqueRoleNameQuery;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryUniqueRoleNameQueryTest extends KernelTestCase
{
    use RoleFixtureBehavior;

    /** @var UniqueRoleNameQuery */
    private $roleQuery;

    /** @var RoleRepository */
    private $repository;

    protected function setUp()
    {
        $this->repository = new InMemoryRoleRepository();

        $this->roleQuery = new InMemoryUniqueRoleNameQuery(
            $this->repository
        );
    }

    /** @test */
    public function can_return_not_unique_role_name_if_role_name_exist(): void
    {
        $role = $this->generateRoleAggregate();
        $this->writeData($role);

        $this->assertFalse($this->roleQuery->execute($role->name()));
    }

    /** @test */
    public function can_return_unique_role_name_if_role_name_not_exist(): void
    {
        $this->assertTrue($this->roleQuery->execute(RoleName::fromString('unknown-role-name')));
    }

    protected function writeData(object $data): void
    {
        $this->repository->add($data);
    }

    protected function tearDown()
    {
        $this->repository = null;
        $this->roleQuery = null;
        parent::tearDown();
    }
}
