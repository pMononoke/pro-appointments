<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

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
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineUserQueryTest extends KernelTestCase
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
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query\UserQuery');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');
    }

    /** @test */
    public function can_find_a_user_by_user_id(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->pupulateDatabase($user);

        $userFromDatabase = $this->userQuery->execute($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
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
