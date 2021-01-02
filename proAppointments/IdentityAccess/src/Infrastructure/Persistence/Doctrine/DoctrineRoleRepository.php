<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRemoveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;

/**
 * Class DoctrineRoleRepository.
 *
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 */
class DoctrineRoleRepository extends ServiceEntityRepository implements RoleRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    public function nextIdentity(): RoleId
    {
        return RoleId::generate();
    }

    /**
     * @throws RoleAlreadyExist
     */
    public function add(Role $role): void
    {
        if ($this->roleExist($role->id())) {
            throw RoleAlreadyExist::withId($role->id());
        }

        $this->_em->persist($role);
        //TODO remove
        $this->_em->flush($role);
    }

    /**
     * @throws RoleNotFound
     */
    public function ofId(RoleId $roleId): Role
    {
        if (!$this->roleExist($roleId)) {
            throw RoleNotFound::withId($roleId);
        }

        return $this->find($roleId);
    }

    /**
     * @throws RoleNotFound
     */
    public function update(Role $role): void
    {
        // TODO: Implement update() method.
    }

    /**
     * @throws ImpossibleToRemoveRole
     */
    public function remove(Role $role): void
    {
        $this->_em->remove($role);
        //TODO remove
        $this->_em->flush($role);
    }

    public function roleExist(RoleId $roleId): bool
    {
        $exist = true;

        if (null === $this->find($roleId)) {
            $exist = false;
        }

        return $exist;
    }
}
