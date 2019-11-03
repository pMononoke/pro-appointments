<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

use ProAppointments\IdentityAccess\Domain\User\UserFactory as UserFactoryPort;

class UserFactoryImp implements UserFactoryPort
{
    public function build(UserId $userId, UserEmail $email, UserPassword $password, ?FullName $fullName): User
    {
        return User::register(
            $userId,
            $email,
            $password,
            $fullName
        );
    }
}
