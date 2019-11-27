<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use ProAppointments\IdentityAccess\Application\Service\Query\RoleQuery as RoleQueryPort;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;

class RoleQuery implements RoleQueryPort
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(RoleId $id): ?Role
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('Role')
            ->from(Role::class, 'Role')
            ->where('Role.id = :RoleId')
            ->setParameter('RoleId', $id->toString());

        $role = $queryBuilder->getQuery()->getOneOrNullResult();

        return $role;
    }
}
