<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;

abstract class UserServiceTestCase extends ApplicationServiceTestCase
{
    private const TABLES = ['ia_user', 'ia_domain_event', 'ia_person'];

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
