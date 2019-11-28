<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

use ProAppointments\IdentityAccess\Domain\User\Exception\UserAlreadyExist;
use ProAppointments\IdentityAccess\Domain\User\Exception\UserNotFound;

interface UserRepository
{
    /**
     * @throws UserAlreadyExist
     */
    public function register(User $user): void;

    /**
     * @throws UserNotFound
     */
    public function ofId(UserId $userId): User;

    public function nextIdentity(): UserId;

    public function remove(User $user): void;

    public function save(User $user): void;
}
