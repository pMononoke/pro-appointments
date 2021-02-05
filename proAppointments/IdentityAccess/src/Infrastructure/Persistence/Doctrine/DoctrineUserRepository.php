<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry;
use ProAppointments\IdentityAccess\Application\ViewModel\ImmutableUserInterface;
use ProAppointments\IdentityAccess\Application\ViewModel\UserAccount;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Security\SecurityUserAdapter;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class DoctrineUserRepository.
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 */
class DoctrineUserRepository extends ServiceEntityRepository implements UserLoaderInterface
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
        //TODO remove
        $this->_em->flush();
    }

    public function remove(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }

    public function save(User $user): void
    {
        $this->_em->persist($user);
        // TODO IS transational same as register
        $this->_em->flush($user);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => UserEmail::fromString($email)]);
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username): UserInterface
    {
        $user = $this->findOneBy(['email' => UserEmail::fromString($username)]);

        return new SecurityUserAdapter($user);
    }

    public function loadUserAccountByUserId(UserId $userId): ?ImmutableUserInterface
    {
        if (null === $user = $this->find($userId)) {
            return null;
        }

        return new UserAccount($user);
    }
}
