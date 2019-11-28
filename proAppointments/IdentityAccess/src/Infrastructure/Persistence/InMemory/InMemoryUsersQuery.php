<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Application\Service\Query\UsersQuery;
use ProAppointments\IdentityAccess\Domain\User\User;

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
        // TODO implement this method in in memory user repository
        return $this->userRepository->findAll($limit);
    }
}
