<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use Doctrine\Common\Collections\ArrayCollection;
use ProAppointments\IdentityAccess\Application\ViewModel\ImmutableUserInterface;
use ProAppointments\IdentityAccess\Application\ViewModel\UserAccount;
use ProAppointments\IdentityAccess\Domain\Identity\Exception\UserAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Identity\Exception\UserNotFound;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

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

    /** READ SIDE QUERY */
    public function findAll(int $limit = 1000): array
    {
        return $this->userCollection->toArray();
    }

    /** READ SIDE QUERY */
    public function findUniqueUserEmail(UserEmail $userEmail): bool
    {
        $isUniqueUserEmail = false;

        $usersByEmail = $this->userCollection->filter(function (User $user) use ($userEmail) {
            return $user->email()->equals($userEmail);
        });

        if ($usersByEmail->isEmpty()) {
            $isUniqueUserEmail = true;
        }

        return $isUniqueUserEmail;
    }

    public function loadUserAccountByUserId(UserId $userId): ?ImmutableUserInterface
    {
        if (!$this->userExist($userId)) {
            return null;
        }

        return new UserAccount($this->userCollection->get($userId->toString()));
    }
}
