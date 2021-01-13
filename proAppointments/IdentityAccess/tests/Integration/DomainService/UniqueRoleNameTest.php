<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\DomainService;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleNameInterface;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleRepository;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUniqueRoleNameQuery;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UniqueRoleNameTest extends kernelTestCase
{
    use RoleFixtureBehavior;

    /** @var UniqueRoleNameInterface */
    private $uniqueRoleNameService;

    /** @var roleRepository */
    private $roleRepository;

    protected function setUp()
    {
        $this->markTestIncomplete('** DOVREBBE ESSERE UN TEST UNITARIO **');
        $kernel = self::bootKernel();

        $this->uniqueRoleNameService = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleName');
        $this->roleRepository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\RoleRepositoryAdapter');
    }

    /** @test */
    public function a_roleName_is_unique_if_roleName_not_exist_in_the_system(): void
    {
        self::assertTrue($this->uniqueRoleNameService->__invoke(RoleName::fromString('irrelevant')));
    }

    /** @test */
    public function a_roleName_is_not_unique_if_roleName_exist_in_the_system(): void
    {
        $role = $this->generateRoleAggregate();
        $this->roleRepository->add($role);

        self::assertFalse(($this->uniqueRoleNameService)(RoleName::fromString('irrelevant')));
    }

    /** @test */
    public function IN_MEMORY_a_roleName_is_unique_if_roleName_not_exist_in_the_system(): void
    {
        $query = new InMemoryUniqueRoleNameQuery($roleRepository = new InMemoryRoleRepository());
        $uniqueRoleNameService = new \ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleName($query);

        self::assertTrue(($uniqueRoleNameService)(RoleName::fromString('irrelevant')));
    }

    /** @test */
    public function IN_MEMORY_VERSION_a_roleName_is_not_unique_if_roleName_exist_in_the_system(): void
    {
        $query = new InMemoryUniqueRoleNameQuery($roleRepository = new InMemoryRoleRepository());
        $uniqueRoleNameService = new \ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleName($query);

        $role = $this->generateRoleAggregate();
        $roleRepository->add($role);

        self::assertFalse(($uniqueRoleNameService)(RoleName::fromString('irrelevant')));
    }

    protected function tearDown()
    {
        $this->uniqueRoleNameService = null;
        $this->roleRepository = null;
    }
}
