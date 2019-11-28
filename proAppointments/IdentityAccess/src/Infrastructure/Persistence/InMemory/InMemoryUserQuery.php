<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Application\Service\Query\UserQuery;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;

class InMemoryUserQuery implements UserQuery
{
    /** @var InfrastructureUserRepository */
    private $userRepository;

    public function __construct(InfrastructureUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserId $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
