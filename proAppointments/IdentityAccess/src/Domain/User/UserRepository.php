<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

interface UserRepository
{
    public function register(User $user): void;

    public function ofId(UserId $userId): User;

    public function nextIdentity(): UserId;

    public function remove(User $user): void;
}
