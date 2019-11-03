<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter;

use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserRepository;

class UserRepositoryAdapter implements UserRepository
{
    /** @var UserRepository */
    private $repository;

    /**
     * UserRepositoryAdapter constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function register(User $user): void
    {
        $this->repository->register($user);
    }

    public function ofId(UserId $userId): User
    {
        $this->repository->ofId($userId);
    }

    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }
}
