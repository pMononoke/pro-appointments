<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\Service\Query;

interface UsersQuery
{
    public function execute(int $limit): array;
}
