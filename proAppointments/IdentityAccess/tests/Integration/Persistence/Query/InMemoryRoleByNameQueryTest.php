<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\RoleByNameQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleByNameQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleRepository;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryRoleByNameQueryTest extends KernelTestCase
{
    use RoleFixtureBehavior;

    private const TABLES = ['ia_user', 'ia_person'];

    /** @var RoleByNameQuery */
    private $roleQuery;

    /** @var RoleRepository */
    private $repository;

    protected function setUp()
    {
        $this->repository = new InMemoryRoleRepository();

        $this->roleQuery = new InMemoryRoleByNameQuery(
            $this->repository
        );
    }

    /** @test */
    public function can_find_a_role_by_roleName(): void
    {
        $role = $this->generateRoleAggregate();
        $this->writeData($role);

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
