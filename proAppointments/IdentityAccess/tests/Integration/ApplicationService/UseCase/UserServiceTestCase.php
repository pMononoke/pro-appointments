<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

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
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;

abstract class UserServiceTestCase extends ApplicationServiceTestCase
{
    private const TABLES = ['ia_user', 'ia_domain_event', 'ia_person'];

    private const EMAIL = 'irrelevant@email.com';
    private const PASSWORD = 'irrelevant';
    private const FIRST_NAME = 'irrelevantt';
    private const LAST_NAME = 'irrelevant';
    private const MOBILE_NUMBER = '+39-392-1111111';

    /** @var UserRepository */
    protected $userRepository;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->userRepository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineUserRepository');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');
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

    protected function retrieveUserById(UserId $userId)
    {
        //return $this->userRepository->ofId($userId);

        $this->entityManager->clear();

        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('User')
            ->from(User::class, 'User')
            ->where('User.id = :UserId')
            ->setParameter('UserId', $userId->toString());

        $user = $queryBuilder->getQuery()->getOneOrNullResult();

        return $user;
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
        $this->userRepository = null;
        parent::tearDown();
    }
}
