<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter;

use ProAppointments\IdentityAccess\Domain\User\Exception\UserAlreadyExist;
use ProAppointments\IdentityAccess\Domain\User\Exception\UserNotFound;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserRepository;

class UserRepositoryAdapter implements UserRepository
{
//    /** @var UserRepository */
    private $repository;

    /**
     * UserRepositoryAdapter constructor.
     *
     * @param object $repository
     */
    public function __construct(object $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param User $user
     *
     * @throws UserAlreadyExist
     */
    public function register(User $user): void
    {
        if ($this->repository->ofId($user->id())) {
            throw  UserAlreadyExist::withId($user->id());
        }
        $this->repository->register($user);
    }

    /**
     * @param UserId $userId
     *
     * @return User
     *
     * @throws UserNotFound
     */
    public function ofId(UserId $userId): User
    {
        if (null === $user = $this->repository->ofId($userId)) {
            throw  UserNotFound::withId($userId);
        }

        return $user;
//        if ($user = $this->repository->ofId($userId)) {
//            return $user;
//        }
//
//        throw  UserNotFound::withId($userId);
    }

    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }
}
