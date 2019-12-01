<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail;

use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;

interface UniqueUserEmailInterface
{
    public function __invoke(UserEmail $userEmail): bool;
}
