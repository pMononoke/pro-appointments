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
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryRoleByNameQueryTest extends KernelTestCase
{
    private const TABLES = ['ia_user', 'ia_person'];

    private const ROLE_NAME = 'irrelevant';
    private const ROLE_DESCRIPTION = 'irrelevant';

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
