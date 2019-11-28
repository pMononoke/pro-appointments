<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Application\Service\Query\UsersQuery;

class InMemoryUsersQuery implements UsersQuery
{
    /** @var InfrastructureUserRepository */
    private $userRepository;

    public function __construct(InfrastructureUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute($limit = 1000): array
    {
        return $this->userRepository->findAll($limit);
    }
}
