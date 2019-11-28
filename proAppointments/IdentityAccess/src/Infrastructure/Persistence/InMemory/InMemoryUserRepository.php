<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use Doctrine\Common\Collections\ArrayCollection;
use ProAppointments\IdentityAccess\Domain\User\Exception\UserAlreadyExist;
use ProAppointments\IdentityAccess\Domain\User\Exception\UserNotFound;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;

class InMemoryUserRepository implements InfrastructureUserRepository
{
    /** @var ArrayCollection */
    private $userCollection;

    public function __construct()
    {
        $this->userCollection = new ArrayCollection([]);
    }

    /**
     * @throws UserAlreadyExist
     */
    public function register(User $user): void
    {
        if ($this->userExist($user->id())) {
            throw UserAlreadyExist::withId($user->id());
        }

        $this->userCollection->set($user->id()->toString(), $user);
    }

    /**
     * @throws UserNotFound
     */
    public function ofId(UserId $userId): User
    {
        //var_dump($this->userExist($userId));
        if ($this->userExist($userId)) {
            return $this->userCollection->get($userId->toString());
        }

        throw UserNotFound::withId($userId);
    }

    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }

    public function remove(User $user): void
    {
        $this->userCollection->remove($user->id()->toString());
    }

    public function save(User $user): void
    {
        if (!$this->userExist($user->id())) {
            throw UserNotFound::withId($user->id());
        }

        $this->userCollection->set($user->id()->toString(), $user);
    }

    // TODO make private
    public function userExist(UserId $userId): bool
    {
        return $this->userCollection->containsKey($userId->toString());
    }

    /** READ SIDE QUERY */
    public function findById(UserId $userId): ?User
    {
        return $this->userCollection->get($userId->toString());
    }
}