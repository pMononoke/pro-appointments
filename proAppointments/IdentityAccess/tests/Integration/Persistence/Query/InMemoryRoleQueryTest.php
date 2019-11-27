<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Application\Service\Query\RoleQuery;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleDescription;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InfrastructureRoleRepository;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleCollection;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryRoleQueryTest extends KernelTestCase
{
    private const TABLES = ['ia_user', 'ia_person'];

    private const ROLE_NAME = 'irrelevant';
    private const ROLE_DESCRIPTION = 'irrelevant';

    /** @var RoleQuery */
    private $roleQuery;

    /** @var InfrastructureRoleRepository */
    private $repository;

    protected function setUp()
    {
        $this->repository = new InMemoryRoleRepository();

        $this->roleQuery = new InMemoryRoleQuery(
            new InMemoryRoleCollection($this->repository)
        );
    }

    /** @test */
    public function can_find_a_role_by_role_id(): void
    {
        $role = $this->generateRoleAggregate();
        $this->writeData($role);

        $userFromQuery = $this->roleQuery->execute($role->id());

        self::assertTrue($role->sameIdentityAs($userFromQuery));
    }

    /** @test */
    public function query_by_role_id_return_a_null_value(): void
    {
        $userFromQuery = $this->roleQuery->execute(RoleId::generate());

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
