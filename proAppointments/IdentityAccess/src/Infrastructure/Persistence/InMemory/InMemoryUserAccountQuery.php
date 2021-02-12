<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use ProAppointments\IdentityAccess\Application\Service\Query\UserAccountQuery;
use ProAppointments\IdentityAccess\Application\ViewModel\ImmutableUserInterface;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class InMemoryUserAccountQuery implements UserAccountQuery
{
    /** @var InMemoryUserRepository */
    private $userRepository;

    public function __construct(InMemoryUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserId $id): ?ImmutableUserInterface
    {
        return $this->userRepository->loadUserAccountByUserId($id);
    }
}
