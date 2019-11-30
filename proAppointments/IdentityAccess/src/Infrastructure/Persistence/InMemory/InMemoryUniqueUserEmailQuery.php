<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmailQuery;

class InMemoryUniqueUserEmailQuery implements UniqueUserEmailQuery
{
    /** @var InfrastructureUserRepository */
    private $userRepository;

    public function __construct(InfrastructureUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserEmail $userEmail): bool
    {
        return $this->userRepository->findUniqueUserEmail($userEmail);
    }
}
