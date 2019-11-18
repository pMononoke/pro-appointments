<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use ProAppointments\IdentityAccess\Application\Service\Query\UsersQuery as UsersQueryPort;
use ProAppointments\IdentityAccess\Domain\User\User;

class UsersQuery implements UsersQueryPort
{
    private const LIMIT = 1000;
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * UsersQuery constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(int $limit = self::LIMIT): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('User')
            ->from(User::class, 'User')
            ->setMaxResults($limit);

        $users = $queryBuilder->getQuery()->getResult();

        return $users;
    }
}
