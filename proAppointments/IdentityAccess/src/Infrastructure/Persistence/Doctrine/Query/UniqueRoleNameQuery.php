<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleNameQuery as UniqueRoleNameQueryPort;

class UniqueRoleNameQuery implements UniqueRoleNameQueryPort
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(RoleName $roleName): bool
    {
        $isUniqueUserRoleName = false;

        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('Role')
            ->from(Role::class, 'Role')
            ->where('Role.name = :roleName')
            ->setMaxResults(1)
            ->setParameter('roleName', $roleName->toString());

        if (!$queryBuilder->getQuery()->getOneOrNullResult()) {
            $isUniqueUserRoleName = true;
        }

        return $isUniqueUserRoleName;
    }
}
