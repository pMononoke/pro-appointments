<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

interface UserFactory
{
    public function build(UserId $userId, UserEmail $email, UserPassword $password, FullName $fullName): User;
}
