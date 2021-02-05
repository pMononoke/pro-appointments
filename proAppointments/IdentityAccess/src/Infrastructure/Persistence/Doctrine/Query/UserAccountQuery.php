<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use ProAppointments\IdentityAccess\Application\Service\Query\UserAccountQuery as UserAccountQueryPort;
use ProAppointments\IdentityAccess\Application\ViewModel\ImmutableUserInterface;
use ProAppointments\IdentityAccess\Application\ViewModel\UserAccount;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class UserAccountQuery implements UserAccountQueryPort
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * UserQuery constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(UserId $id): ?ImmutableUserInterface
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('User')
            ->from(User::class, 'User')
            ->where('User.id = :UserId')
            ->setParameter('UserId', $id->toString());

        if (null === $userOrNull = $queryBuilder->getQuery()->getOneOrNullResult()) {
            return null;
        }

        return new UserAccount($userOrNull);
    }
}
