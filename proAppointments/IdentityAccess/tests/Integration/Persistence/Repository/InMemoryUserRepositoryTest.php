<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Repository;

use ProAppointments\IdentityAccess\Domain\User\ContactInformation;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\FullName;
use ProAppointments\IdentityAccess\Domain\User\LastName;
use ProAppointments\IdentityAccess\Domain\User\MobileNumber;
use ProAppointments\IdentityAccess\Domain\User\Person;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;
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
//        $kernel = self::bootKernel();
//
//        $this->userRepository = $kernel->getContainer()
//            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineUserRepository');
        $this->userRepository = new InMemoryUserRepository();
    }

    /** @test */
    public function can_register_and_retrieve_a_user(): void
    {
        //self::markTestSkipped();
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->register($user);
        $userFromDatabase = $this->userRepository->ofId($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
    }

    /** @test */
    public function can_register_and_remove_a_user(): void
    {
        //self::markTestSkipped();
        $first = list($id, $user) = $this->generateUserAggregate();
        $second = list($secondId, $secondUser) = $this->generateUserAggregate();

        $this->userRepository->register($user);
        $this->userRepository->register($secondUser);

        // remove first
        $this->userRepository->remove($user);
        $userFromDatabase = $this->userRepository->ofId($secondId);

        self::assertFalse($this->userRepository->userExist($id));
        $this->assertTrue($secondUser->sameIdentityAs($userFromDatabase));
    }

    /** @test */
    public function can_save_and_retrieve_a_user(): void
    {
        //self::markTestSkipped();
        list($id, $user) = $this->generateUserAggregate();
        $this->userRepository->register($user);

        $this->userRepository->save($user);
        $userFromDatabase = $this->userRepository->ofId($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
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

    /** @test */
    public function execution_of_findById_query_return_null(): void
    {
        $userFromDatabase = $this->userRepository->findById(UserId::generate());

        $this->assertNull($userFromDatabase);
    }

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
