<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

interface UserRepository
{
    /**
     * @throws Exception\UserAlreadyExist
     */
    public function register(User $user): void;

    /**
     * @throws Exception\UserNotFound
     */
    public function ofId(UserId $userId): User;

    public function nextIdentity(): UserId;

    public function remove(User $user): void;

    public function save(User $user): void;
}
