<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Repository;

use ProAppointments\IdentityAccess\Domain\Identity\ContactInformation;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\FullName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\Person;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryUserRepositoryTest extends KernelTestCase
{
    private const EMAIL = 'irrelevant@email.com';
    private const PASSWORD = 'irrelevant';
    private const FIRST_NAME = 'irrelevant';
    private const LAST_NAME = 'irrelevant';
    private const MOBILE_NUMBER = '+39-392-1111111';

    private $userRepository;

    protected function setUp()
    {
        $this->userRepository = new InMemoryUserRepository();
    }

    /** @test */
    public function can_generate_a_new_identifier_for_a_user(): void
    {
        $newIdentity = $this->userRepository->nextIdentity();

        self::assertInstanceOf(UserId::class, $newIdentity);
    }

    /** @test */
    public function can_register_a_user(): void
    {
        //self::markTestSkipped();
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->register($user);
        $userFromDatabase = $this->userRepository->ofId($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\UserAlreadyExist
     */
    public function can_not_register_a_user_and_throw_UserAlreadyExist(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->register($user);
        $this->userRepository->register($user);
    }

    /** @test */
    public function can_retrieve_a_user_by_userId()
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->userRepository->register($user);

        $roleFromDatabase = $this->userRepository->ofId($user->Id());

        $this->assertTrue($user->sameIdentityAs($roleFromDatabase));
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\UserNotFound
     */
    public function can_not_retrieve_a_user_by_userId_and_throw_UserNotFound()
    {
        $this->userRepository->ofId(UserId::generate());
    }

    /** @test */
    public function can_update_a_user(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $newPassword = UserPassword::fromString('new-password');
        $this->userRepository->register($user);
        $user->changeAccessCredentials($newPassword);

        $this->userRepository->save($user);

        $userFromDatabase = $this->userRepository->ofId($id);
        $this->assertTrue($userFromDatabase->password()->equals($newPassword));
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\UserNotFound
     */
    public function can_not_update_a_user_and_throw_UserNotFound(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->save($user);
    }

    /** @test */
    public function can_remove_a_user(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->userRepository->register($user);

        $this->userRepository->remove($user);

        self::assertFalse($this->userRepository->userExist($id));
    }

    /** READ SIDE QUERY */

    /** @test */
    public function can_execute_findById_query(): void
    {
        $first = list($id, $user) = $this->generateUserAggregate();
        $this->userRepository->register($user);

        $userFromDatabase = $this->userRepository->findById($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
    }

    /** READ SIDE QUERY */

    /** @test */
    public function execution_of_findById_query_return_null(): void
    {
        $userFromDatabase = $this->userRepository->findById(UserId::generate());

        $this->assertNull($userFromDatabase);
    }

    /** READ SIDE QUERY */

    /** @test */
    public function can_execute_findeAll_query(): void
    {
        $first = list($id, $user) = $this->generateUserAggregate();
        $second = list($secondId, $secondUser) = $this->generateUserAggregate();
        $third = list($thirdId, $thirdUser) = $this->generateUserAggregate();
        $this->userRepository->register($user);
        $this->userRepository->register($secondUser);
        $this->userRepository->register($thirdUser);

        $usersFromDatabase = $this->userRepository->findAll();

        $this->assertEquals(3, count($usersFromDatabase));
    }

    protected function generateUserAggregate(): array
    {
        $id = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $person = new Person($id, $fullName, $contactInformation);
        $user = User::register(
            $id,
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        return [$id, $user];
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->userRepository = null;
    }
}
