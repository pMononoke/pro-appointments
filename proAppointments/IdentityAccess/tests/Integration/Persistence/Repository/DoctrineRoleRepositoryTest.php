<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Repository;

use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group doctrine
 */
class DoctrineRoleRepositoryTest extends KernelTestCase
{
    use RoleFixtureBehavior;

    private $repository;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->repository = $kernel->getContainer()
            ->get('test.ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineRoleRepository');
    }

    /** @test */
    public function can_generate_a_new_identifier_for_a_role(): void
    {
        $newIdentity = $this->repository->nextIdentity();

        self::assertInstanceOf(RoleId::class, $newIdentity);
    }

    /** @test */
    public function can_add_a_role()
    {
        $role = $this->generateRoleAggregate();

        $this->repository->add($role);

        $this->assertTrue($this->repository->roleExist($role->id()));
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist
     */
    public function can_not_add_a_role_and_throw_RoleAlreadyExist()
    {
        $role = $this->generateRoleAggregate();

        $this->repository->add($role);
        $this->repository->add($role);

        //$this->assertTrue($this->repository->roleExist($role->id()));
    }

    /** @test */
    public function can_retrieve_a_role_by_roleId()
    {
        $role = $this->generateRoleAggregate();
        $this->repository->add($role);

        $roleFromDatabase = $this->repository->ofId($role->Id());

        $this->assertTrue($role->sameIdentityAs($roleFromDatabase));
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound
     */
    public function can_retrieve_a_role_by_roleId_and_throw_RoleNotFound()
    {
        $this->repository->ofId(RoleId::generate());
    }

    /** @test */
    public function can_update_a_role()
    {
        //self::markTestSkipped('No update methods in Role aggregate for now.');

        $role = $this->generateRoleAggregate();
        $this->repository->add($role);

        //TODO add modify method call here.
        $this->repository->update($role);

        //TODO check modification here. (for now it check existence)
        $this->assertTrue($this->repository->roleExist($role->id()));
    }

    /** @test */
    public function can_remove_a_role()
    {
        $role = $this->generateRoleAggregate();
        $this->repository->add($role);

        $this->repository->remove($role);

        $this->assertFalse($this->repository->roleExist($role->id()));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->repository = null;
    }
}
