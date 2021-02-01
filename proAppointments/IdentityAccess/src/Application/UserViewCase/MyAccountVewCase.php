<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserViewCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Application\Service\Query\UserQuery;
use ProAppointments\IdentityAccess\Domain\Identity\User;

/**
 * Class MyAccountVewCase.
 */
class MyAccountVewCase implements ApplicationService
{
    /** @var UserQuery */
    private $repository;

    /**
     * MyAccountVewCase constructor.
     */
    public function __construct(UserQuery $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param MyAccountRequest $request
     *
     * @return User|null
     */
    public function execute($request)
    {
        return $this->repository->execute(
            $request->issuer()
        );
    }
}
