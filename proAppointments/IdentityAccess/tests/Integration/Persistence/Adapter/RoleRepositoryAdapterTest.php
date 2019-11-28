<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter;

use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleDescription;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter;
use ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter\UserRepositoryWithDoctrineError\UserRepositoryWithORMException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RoleRepositoryAdapterTest extends KernelTestCase
{
    private const ROLE_NAME = 'irrelevant';
    private const ROLE_DESCRIPTION = 'irrelevant';

    private $roleRepository;

    protected function setUp()
    {
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

        // remove first
        $this->roleRepository->remove($firstRole);
        $userFromDatabase = $this->roleRepository->ofId($secondRole->id());

        //self::assertNull($this->userRepository->ofId($id));
        $this->assertTrue($secondRole->sameIdentityAs($userFromDatabase));
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist
     */
    public function deny_persistence_and_throw_RoleAlreadyExist_exception_if_role_exist(): void
    {
        $role = $this->generateRoleAggregate();

        $this->roleRepository->add($role);

        $this->roleRepository->add($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound
     */
    public function throw_RoleNotFound_exception_if_role_not_exist(): void
    {
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

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound
     */
    public function can_not_update_a_role_and_throw_RoleNotFound_exception(): void
    {
        $role = $this->generateRoleAggregate();

        $this->roleRepository->update($role);
    }

//    /**
//     * @test
//     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\ImpossibleToRemoveUser
//     */
//    public function detect_doctrine_ORMException_on_remove_and_throw_ImpossibeToRemoveUser_exception(): void
//    {
//        list($id, $role) = $this->generateUserAggregate();
//
//        $roleRepositoryAdapter = new UserRepositoryAdapter(new UserRepositoryWithORMException());
//
//        $roleRepositoryAdapter->remove($role);
//    }
//
    protected function generateRoleAggregate(): Role
    {
        $id = RoleId::generate();
        $name = RoleName::fromString(self::ROLE_NAME);
        $description = RoleDescription::fromString(self::ROLE_DESCRIPTION);
        $role = new Role($id, $name, $description);

        return $role;
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->roleRepository = null;
    }
}
