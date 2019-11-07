<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Adapter;

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
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryAdapterTest extends KernelTestCase
{
    private const EMAIL = 'irrelevant@email.com';
    private const PASSWORD = 'irrelevant';
    private const FIRST_NAME = 'irrelevant';
    private const LAST_NAME = 'irrelevant';
    private const MOBILE_NUMBER = '+39-392-1111111';

    private $userRepository;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->userRepository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter');
    }

    /** @test */
    public function can_persist_and_retrieve_a_user(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->register($user);
        $userFromDatabase = $this->userRepository->ofId($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
    }

    /** @test */
    public function can_persist_and_remove_a_user(): void
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

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\User\Exception\UserAlreadyExist
     */
    public function deny_persistence_and_throw_UserAlreadyExist_exception_if_user_exist(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->register($user);

        $this->userRepository->register($user);
    }

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\User\Exception\UserNotFound
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
     * @return array
     */
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