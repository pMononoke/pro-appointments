<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter;

use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RoleRepositoryAdapterTest extends KernelTestCase
{
    use RoleFixtureBehavior;

    private $roleRepository;

    protected function setUp()
    {
        $this->markTestIncomplete('** DOVREBBE ESSERE UN TEST UNITARIO E LO ROLE REPOSITORY DOCTRINE DOVREBBE ESSERE INTEGRATION TEST.**');
        $kernel = self::bootKernel();

        $this->roleRepository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\RoleRepositoryAdapter');
    }

    /** @test*/
    public function can_generate_a_new_role_identity(): void
    {
        self::assertInstanceOf(RoleId::class, $this->roleRepository->nextIdentity());
    }

    /** @test */
    public function can_add_and_retrieve_a_role(): void
    {
        $role = $this->generateRoleAggregate();

        $this->roleRepository->add($role);
        $roleFromDatabase = $this->roleRepository->ofId($role->id());

        $this->assertTrue($role->sameIdentityAs($roleFromDatabase));
    }

    /** @test */
    public function can_add_and_remove_a_role(): void
    {
        $firstRole = $this->generateRoleAggregate();
        $secondRole = $this->generateRoleAggregate();

        $this->roleRepository->add($firstRole);
        $this->roleRepository->add($secondRole);

        $this->roleRepository->remove($firstRole);
        $userFromDatabase = $this->roleRepository->ofId($secondRole->id());

        $this->assertTrue($secondRole->sameIdentityAs($userFromDatabase));
    }

    /** @test */
    public function deny_persistence_and_throw_RoleAlreadyExist_exception_if_role_exist(): void
    {
        self::expectException(RoleAlreadyExist::class);

        $role = $this->generateRoleAggregate();

        $this->roleRepository->add($role);

        $this->roleRepository->add($role);
    }

    /** @test */
    public function throw_RoleNotFound_exception_if_role_not_exist(): void
    {
        self::expectException(RoleNotFound::class);

        $this->roleRepository->ofId(RoleId::generate());
    }

    /** @test */
    public function can_update_and_retrieve_a_role(): void
    {
        $role = $this->generateRoleAggregate();

        $this->roleRepository->add($role);
        $this->roleRepository->update($role);
        $roleFromDatabase = $this->roleRepository->ofId($role->id());

        $this->assertTrue($role->sameIdentityAs($roleFromDatabase));
    }

    /** @test */
    public function can_not_update_a_role_and_throw_RoleNotFound_exception(): void
    {
        self::expectException(RoleNotFound::class);

        $role = $this->generateRoleAggregate();

        $this->roleRepository->update($role);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->roleRepository = null;
    }
}
