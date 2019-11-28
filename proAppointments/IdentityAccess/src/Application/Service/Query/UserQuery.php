<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\Service\Query;

use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

interface UserQuery
{
    public function execute(UserId $id): ?User;
}
