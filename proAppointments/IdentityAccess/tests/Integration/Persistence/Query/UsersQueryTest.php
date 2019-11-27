<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

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

class UsersQueryTest extends KernelTestCase
{
    private const TABLES = ['ia_user', 'ia_person'];

    private const EMAIL = 'irrelevant@email.com';
    private const PASSWORD = 'irrelevant';
    private const FIRST_NAME = 'irrelevant';
    private const LAST_NAME = 'irrelevant';
    private const MOBILE_NUMBER = '+39-392-1111111';

    private $userQuery;

    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->userQuery = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query\UsersQuery');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');
    }

    /** @test */
    public function can_find_all_users(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->writeData($user);
        list($id2, $user2) = $this->generateUserAggregate();
        $this->writeData($user2);
        list($id3, $user3) = $this->generateUserAggregate();
        $this->writeData($user3);

        $allUsersFromDatabase = $this->userQuery->execute();

        $this->assertEquals(3, count($allUsersFromDatabase));
    }

    /** @test */
    public function can_find_all_users_with_Limit_parameter(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->writeData($user);
        list($id2, $user2) = $this->generateUserAggregate();
        $this->writeData($user2);
        list($id3, $user3) = $this->generateUserAggregate();
        $this->writeData($user3);

        $allUsersFromDatabase = $this->userQuery->execute(2);

        $this->assertEquals(2, count($allUsersFromDatabase));
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

    protected function writeData(object $data): void
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    private function truncateTables(): void
    {
        $this->entityManager->getConnection()->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');
        foreach (self::TABLES as $table) {
            //$this->entityManager->getConnection()->executeQuery(sprintf('TRUNCATE "%s" CASCADE;', $table));
            $this->entityManager->getConnection()->executeQuery(sprintf('TRUNCATE `%s`;', $table));
        }
        $this->entityManager->getConnection()->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
    }

    protected function tearDown()
    {
        $this->truncateTables();
        $this->userQuery = null;
        parent::tearDown();
    }
}
