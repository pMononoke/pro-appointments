<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter;

use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter;
use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter\UserRepositoryWithDoctrineError\UserRepositoryWithDBALException;
use ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter\UserRepositoryWithDoctrineError\UserRepositoryWithORMException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryAdapterTest extends KernelTestCase
{
    use UserFixtureBehavior;

    private $userRepository;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->userRepository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter');
    }

    /** @test */
    public function can_register_and_retrieve_a_user(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->register($user);
        $userFromDatabase = $this->userRepository->ofId($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
    }

    /** @test */
    public function can_register_and_remove_a_user(): void
    {
        $first = list($id, $user) = $this->generateUserAggregate();
        $second = list($secondId, $secondUser) = $this->generateUserAggregate();

        $this->userRepository->register($user);
        $this->userRepository->register($secondUser);

        // remove first
        $this->userRepository->remove($user);
        $userFromDatabase = $this->userRepository->ofId($secondId);

        //self::assertNull($this->userRepository->ofId($id));
        $this->assertTrue($secondUser->sameIdentityAs($userFromDatabase));
    }

    /** @test */
    public function can_save_and_retrieve_a_user(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->save($user);
        $userFromDatabase = $this->userRepository->ofId($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\UserAlreadyExist
     */
    public function deny_persistence_and_throw_UserAlreadyExist_exception_if_user_exist(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->register($user);

        $this->userRepository->register($user);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\UserNotFound
     */
    public function throw_UserNotFound_exception_if_user_not_exist(): void
    {
        $this->userRepository->ofId(UserId::generate());
    }

    /** @test*/
    public function can_generate_a_new_user_identity(): void
    {
        self::assertInstanceOf(UserId::class, $this->userRepository->nextIdentity());
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\ImpossibleToSaveUser
     */
    public function detect_doctrine_ORMException_on_register_and_throw_ImpossibeToSaveUser_exception(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $userRepositoryAdapter = new UserRepositoryAdapter(new UserRepositoryWithORMException());

        $userRepositoryAdapter->register($user);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\ImpossibleToSaveUser
     */
    public function detect_doctrine_DBALException_on_register_and_throw_ImpossibeToSaveUser_exception(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $userRepositoryAdapter = new UserRepositoryAdapter(new UserRepositoryWithDBALException());

        $userRepositoryAdapter->register($user);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\ImpossibleToSaveUser
     */
    public function detect_doctrine_ORMException_on_save_and_throw_ImpossibeToSaveUser_exception(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $userRepositoryAdapter = new UserRepositoryAdapter(new UserRepositoryWithORMException());

        $userRepositoryAdapter->save($user);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\ImpossibleToSaveUser
     */
    public function detect_doctrine_DBALException_on_save_and_throw_ImpossibeToSaveUser_exception(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $userRepositoryAdapter = new UserRepositoryAdapter(new UserRepositoryWithDBALException());

        $userRepositoryAdapter->save($user);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\ImpossibleToRemoveUser
     */
    public function detect_doctrine_ORMException_on_remove_and_throw_ImpossibeToRemoveUser_exception(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $userRepositoryAdapter = new UserRepositoryAdapter(new UserRepositoryWithORMException());

        $userRepositoryAdapter->remove($user);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\ImpossibleToRemoveUser
     */
    public function detect_doctrine_DBALException_on_remove_and_throw_ImpossibeToRemoveUser_exception(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $userRepositoryAdapter = new UserRepositoryAdapter(new UserRepositoryWithDBALException());

        $userRepositoryAdapter->remove($user);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->userRepository = null;
    }
}
