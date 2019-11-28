<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\ORMException;
use PDOException;
use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleDescription;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\RoleRepositoryAdapter;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\NullRepository\NullRoleRepository;

class RoleRepositoryAdapterInfrastructureExceptionTest extends TestCase
{
    private const ROLE_NAME = 'irrelevant';
    private const ROLE_DESCRIPTION = 'irrelevant';

    private $roleRepositoryAdapter;

    protected function setUp()
    {
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole
     */
    public function method_add_throw_ImpossibeToSaveRole_exception_on_ORMException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryWithORMException = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryWithORMException->method('roleExist')
            ->willReturn(false);
        $RoleRepositoryWithORMException->method('add')
            ->willThrowException(ORMException::entityManagerClosed());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryWithORMException);

        $roleRepositoryAdapter->add($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole
     */
    public function method_add_throw_ImpossibeToSaveRole_exception_on_DBALException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryMock = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryMock->method('roleExist')
            ->willReturn(false);
        $RoleRepositoryMock->method('add')
            ->willThrowException(DBALException:: invalidPlatformSpecified());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryMock);

        $roleRepositoryAdapter->add($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole
     */
    public function method_add_throw_ImpossibeToSaveRole_exception_on_PDOException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryMock = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryMock->method('roleExist')
            ->willReturn(false);
        $RoleRepositoryMock->method('add')
            ->willThrowException(new PDOException());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryMock);

        $roleRepositoryAdapter->add($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole
     */
    public function method_update_throw_ImpossibeToSaveRole_exception_on_ORMException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryWithORMException = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryWithORMException->method('roleExist')
            ->willReturn(true);
        $RoleRepositoryWithORMException->method('update')
            ->willThrowException(ORMException::entityManagerClosed());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryWithORMException);

        $roleRepositoryAdapter->update($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole
     */
    public function method_update_throw_ImpossibeToSaveRole_exception_on_DBALException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryMock = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryMock->method('roleExist')
            ->willReturn(true);
        $RoleRepositoryMock->method('update')
            ->willThrowException(DBALException:: invalidPlatformSpecified());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryMock);

        $roleRepositoryAdapter->update($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole
     */
    public function method_update_throw_ImpossibeToSaveRole_exception_on_PDOException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryMock = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryMock->method('roleExist')
            ->willReturn(true);
        $RoleRepositoryMock->method('update')
            ->willThrowException(new PDOException());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryMock);

        $roleRepositoryAdapter->update($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRemoveRole
     */
    public function method_remove_throw_ImpossibeToRemoveRole_exception_on_ORMException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryMock = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryMock->method('remove')
            ->willThrowException(ORMException::entityManagerClosed());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryMock);
        $roleRepositoryAdapter->remove($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRemoveRole
     */
    public function method_remove_throw_ImpossibeToRemoveRole_exception_on_DBALException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryMock = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryMock->method('remove')
            ->willThrowException(DBALException:: invalidPlatformSpecified());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryMock);

        $roleRepositoryAdapter->remove($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRemoveRole
     */
    public function method_remove_throw_ImpossibeToRemoveRole_exception_on_PDOException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryMock = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryMock->method('remove')
            ->willThrowException(new PDOException());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryMock);

        $roleRepositoryAdapter->remove($role);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRetrieveRole
     */
    public function method_ofId_throw_ImpossibleToRetrieveRole_exception_on_ORMException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryWithORMException = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryWithORMException->method('roleExist')
            ->willReturn(true);
        $RoleRepositoryWithORMException->method('ofId')
            ->willThrowException(ORMException::entityManagerClosed());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryWithORMException);

        $roleRepositoryAdapter->ofId($role->id());
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRetrieveRole
     */
    public function method_ofId_throw_ImpossibleToRetrieveRole_exception_on_DBALException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryMock = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryMock->method('roleExist')
            ->willReturn(true);
        $RoleRepositoryMock->method('ofId')
            ->willThrowException(DBALException:: invalidPlatformSpecified());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryMock);

        $roleRepositoryAdapter->ofId($role->id());
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRetrieveRole
     */
    public function method_ofId_throw_ImpossibleToRetrieveRole_exception_on_PDOException(): void
    {
        $role = $this->generateRoleAggregate();
        $RoleRepositoryMock = $this->createMock(NullRoleRepository::class);
        $RoleRepositoryMock->method('roleExist')
            ->willReturn(true);
        $RoleRepositoryMock->method('ofId')
            ->willThrowException(new PDOException());

        $roleRepositoryAdapter = new RoleRepositoryAdapter($RoleRepositoryMock);

        $roleRepositoryAdapter->ofId($role->id());
    }

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
        $this->roleRepositoryAdapter = null;
    }
}
