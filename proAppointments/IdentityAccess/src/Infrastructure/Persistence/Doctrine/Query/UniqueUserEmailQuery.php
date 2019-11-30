<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmailQuery as UniqueUserEmailQueryPort;

class UniqueUserEmailQuery implements UniqueUserEmailQueryPort
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(UserEmail $userEmail): bool
    {
        $isUniqueUserEmail = false;

        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('user')
            ->from(User::class, 'user')
            ->where('user.email = :UserEmail')
            ->setMaxResults(1)
            ->setParameter('UserEmail', $userEmail->toString());

        if (!$queryBuilder->getQuery()->getOneOrNullResult()) {
            $isUniqueUserEmail = true;
        }

        return $isUniqueUserEmail;
    }
}
