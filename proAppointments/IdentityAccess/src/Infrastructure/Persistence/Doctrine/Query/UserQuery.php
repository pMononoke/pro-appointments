<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use ProAppointments\IdentityAccess\Application\Service\Query\UserQuery as UserQueryPort;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;

class UserQuery implements UserQueryPort
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

    public function execute(UserId $id): ?User
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('User')
            ->from(User::class, 'User')
            ->where('User.id = :UserId')
            ->setParameter('UserId', $id->toString());

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
