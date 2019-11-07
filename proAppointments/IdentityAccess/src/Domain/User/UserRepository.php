<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

interface UserRepository
{
    /**
     * @param User $user
     *
     * @throws Exception\UserAlreadyExist
     */
    public function register(User $user): void;

    /**
     * @param UserId $userId
     *
     * @return User
     *
     * @throws Exception\UserNotFound
     */
    public function ofId(UserId $userId): User;

    /**
     * @return UserId
     */
    public function nextIdentity(): UserId;

    /**
     * @param User $user
     */
    public function remove(User $user): void;
}
