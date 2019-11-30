<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail;

use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;

class UniqueUserEmail
{
    /** @var UniqueUserEmailQuery */
    private $query;

    public function __construct(UniqueUserEmailQuery $query)
    {
        $this->query = $query;
    }

    public function __invoke(UserEmail $userEmail): bool
    {
        // TODO add custom exception ImpossibleToRetrive(Data)
        return $this->query->execute($userEmail);
    }
}
