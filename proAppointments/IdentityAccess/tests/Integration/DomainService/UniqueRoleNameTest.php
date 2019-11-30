<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\DomainService;

use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleName;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleByNameQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryRoleRepository;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UniqueRoleNameTest extends kernelTestCase
{
    use RoleFixtureBehavior;

    /** @var UniqueRoleName */
    private $uniqueRoleNameService;

    /** @var roleRepository */
    private $roleRepository;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->uniqueRoleNameService = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\DomainService\UniqueRoleName');
        $this->roleRepository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\RoleRepositoryAdapter');
        //->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineRoleRepository');
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
        $query = new InMemoryRoleByNameQuery($roleRepository = new InMemoryRoleRepository());
        $uniqueRoleNameService = new \ProAppointments\IdentityAccess\Infrastructure\DomainService\UniqueRoleName($query);

        self::assertTrue(($uniqueRoleNameService)(RoleName::fromString('irrelevant')));
    }

    /** @test */
    public function IN_MEMORY_VERSION_a_roleName_is_not_unique_if_roleName_exist_in_the_system(): void
    {
        $query = new InMemoryRoleByNameQuery($roleRepository = new InMemoryRoleRepository());
        $uniqueRoleNameService = new \ProAppointments\IdentityAccess\Infrastructure\DomainService\UniqueRoleName($query);

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
