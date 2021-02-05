<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\Service\Query;

use ProAppointments\IdentityAccess\Application\ViewModel\ImmutableUserInterface;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

interface UserImmutableQuery
{
    public function execute(UserId $id): ?ImmutableUserInterface;
}
