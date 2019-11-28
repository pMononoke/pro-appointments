<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query;

use Doctrine\ORM\EntityManagerInterface;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\RoleByNameQuery as RoleByNameQueryPort;

class RoleByNameQuery implements RoleByNameQueryPort
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(RoleName $roleName): ?Role
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('Role')
            ->from(Role::class, 'Role')
            ->where('Role.name = :roleName')
            ->setParameter('roleName', $roleName->toString());

        $role = $queryBuilder->getQuery()->getOneOrNullResult();

        return $role;
    }
}
