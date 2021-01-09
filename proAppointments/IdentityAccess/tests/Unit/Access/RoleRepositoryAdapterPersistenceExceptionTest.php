<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\Access;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\ORMException;
use Generator;
use PDOException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRemoveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRetrieveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\RoleRepositoryAdapter;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineRoleRepository;
use ProAppointments\IdentityAccess\Tests\DataFixtures\RoleFixtureBehavior;

class RoleRepositoryAdapterPersistenceExceptionTest extends TestCase
{
    use RoleFixtureBehavior;

    /** @var RoleRepository|MockObject */
    private $implementedRepository;

    /** @var RoleRepositoryAdapter */
    private $roleRepositoryAdapter;

    protected function setUp()
    {
        $this->implementedRepository = $this->createMock(DoctrineRoleRepository::class);
        $this->roleRepositoryAdapter = new RoleRepositoryAdapter($this->implementedRepository);
    }

    /** @test */
    public function addingADuplicatedRoleShouldReturnRoleAlreadyExistException(): void
    {
        self::expectException(RoleAlreadyExist::class);

        $this->implementedRepository->expects($this->any())
            ->method('roleExist')
            ->willReturn(true);

        $this->roleRepositoryAdapter->add($this->generateRoleAggregate());
    }

    /** @test */
    public function updatingAnUnknownRoleShouldReturnRoleNotFoundException(): void
    {
        self::expectException(RoleNotFound::class);

        $this->implementedRepository->expects($this->once())
            ->method('roleExist')
            ->willReturn(false);

        $this->roleRepositoryAdapter->update($this->generateRoleAggregate());
    }

    /** @test */
    public function gettingAnUnknownRoleShouldReturnRoleNotFoundException(): void
    {
        self::expectException(RoleNotFound::class);

        $this->implementedRepository->expects($this->once())
            ->method('roleExist')
            ->willReturn(false);

        $this->roleRepositoryAdapter->ofId($this->generateRoleAggregate()->id());
    }

    /**
     * @test
     * @dataProvider addRoleDataProvider
     */
    public function addingARoleShouldReturnImpossibleToSaveRoleExceptionOnPersistenceError($customException, $calledMethod, $persistenceError): void
    {
        self::expectException($customException);

        $this->implementedRepository->expects($this->any())
            ->method('roleExist')
            ->willReturn(false);

        $this->implementedRepository->expects($this->once())
            ->method($calledMethod)
            ->willThrowException($persistenceError);

        $this->roleRepositoryAdapter->add($this->generateRoleAggregate());
    }

    public function addRoleDataProvider(): Generator
    {
        yield [ImpossibleToSaveRole::class, 'add', ORMException::entityManagerClosed()];
        yield [ImpossibleToSaveRole::class, 'add', DBALException::invalidPlatformSpecified()];
        yield [ImpossibleToSaveRole::class, 'add', new PDOException()];
    }

    /**
     * @test
     * @dataProvider updateRoleDataProvider
     */
    public function updatingARoleShouldReturnCustomExceptionOnPersistenceError($customException, $calledMethod, $persistenceError): void
    {
        self::expectException($customException);

        $this->implementedRepository->expects($this->any())
            ->method('roleExist')
            ->willReturn(true);

        $this->implementedRepository->expects($this->once())
            ->method($calledMethod)
            ->willThrowException($persistenceError);

        $this->roleRepositoryAdapter->update($this->generateRoleAggregate());
    }

    public function updateRoleDataProvider(): Generator
    {
        yield [ImpossibleToSaveRole::class, 'update', ORMException::entityManagerClosed()];
        yield [ImpossibleToSaveRole::class, 'update', DBALException::invalidPlatformSpecified()];
        yield [ImpossibleToSaveRole::class, 'update', new PDOException()];
    }

    /**
     * @test
     * @dataProvider removeRoleDataProvider
     */
    public function removingRoleShouldReturnCustomExceptionOnPersistenceError($customException, $calledMethod, $persistenceError): void
    {
        self::expectException($customException);

        $this->implementedRepository->expects($this->once())
            ->method($calledMethod)
            ->willThrowException($persistenceError);

        $this->roleRepositoryAdapter->remove($this->generateRoleAggregate());
    }

    public function removeRoleDataProvider(): Generator
    {
        yield [ImpossibleToRemoveRole::class, 'remove', ORMException::entityManagerClosed()];
        yield [ImpossibleToRemoveRole::class, 'remove', DBALException::invalidPlatformSpecified()];
        yield [ImpossibleToRemoveRole::class, 'remove', new PDOException()];
    }

    /**
     * @test
     * @dataProvider retrieveRoleDataProvider
     */
    public function retrieveRoleShouldReturnCustomExceptionOnPersistenceError($customException, $calledMethod, $persistenceError): void
    {
        self::expectException($customException);

        $this->implementedRepository->expects($this->any())
            ->method('roleExist')
            ->willReturn(true);

        $this->implementedRepository->expects($this->once())
            ->method($calledMethod)
            ->willThrowException($persistenceError);

        $this->roleRepositoryAdapter->ofId($this->generateRoleAggregate()->id());
    }

    public function retrieveRoleDataProvider(): Generator
    {
        yield [ImpossibleToRetrieveRole::class, 'ofId', ORMException::entityManagerClosed()];
        yield [ImpossibleToRetrieveRole::class, 'ofId', DBALException::invalidPlatformSpecified()];
        yield [ImpossibleToRetrieveRole::class, 'ofId', new PDOException()];
    }

    protected function tearDown()
    {
        $this->implementedRepository = null;
        $this->roleRepositoryAdapter = null;
    }
}
