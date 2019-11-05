<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;

/**
 * Class DoctrineUserRepository.
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 */
class DoctrineUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function ofId(UserId $userId): ?User
    {
        return $this->find($userId);
    }

    public function register(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush($user);
    }
}
