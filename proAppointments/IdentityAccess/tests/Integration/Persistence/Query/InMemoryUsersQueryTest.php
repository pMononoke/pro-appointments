<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Application\Service\Query\UsersQuery;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
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
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUsersQuery;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryUsersQueryTest extends KernelTestCase
{
    private const TABLES = ['ia_user', 'ia_person'];

    private const EMAIL = 'irrelevant@email.com';
    private const PASSWORD = 'irrelevant';
    private const FIRST_NAME = 'irrelevant';
    private const LAST_NAME = 'irrelevant';
    private const MOBILE_NUMBER = '+39-392-1111111';

    /** @var UsersQuery */
    private $usersQuery;

    /** @var RoleRepository */
    private $repository;

    protected function setUp()
    {
        $this->repository = new InMemoryUserRepository();

        $this->usersQuery = new InMemoryUsersQuery(
            $this->repository
        );
    }

    /** @test */
    public function can_find_all_users(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->pupulateDatabase($user);

        list($id, $user2) = $this->generateUserAggregate();
        $this->pupulateDatabase($user2);
        list($id, $user3) = $this->generateUserAggregate();
        $this->pupulateDatabase($user3);
        list($id, $user4) = $this->generateUserAggregate();
        $this->pupulateDatabase($user4);

        $allUsersFromDatabase = $this->usersQuery->execute();

        $this->assertEquals(4, count($allUsersFromDatabase));
    }

    /** @test */
    public function querying_all_users_return_emty_list(): void
    {
        $allUsersFromDatabase = $this->usersQuery->execute();
        $this->assertEquals(0, count($allUsersFromDatabase));
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

    private function pupulateDatabase(object $data): void
    {
        $this->writeData($data);
    }

    protected function writeData(object $data): void
    {
        $this->repository->register($data);
    }

    protected function tearDown()
    {
        $this->repository = null;
        $this->usersQuery = null;
        parent::tearDown();
    }
}
