<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserViewCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Application\Service\Query\UserAccountQuery;
use ProAppointments\IdentityAccess\Application\ViewModel\ImmutableUserInterface;

/**
 * Class MyAccountVewCase.
 */
class MyAccountVewCase implements ApplicationService
{
    /** @var UserAccountQuery */
    private $repository;

    /**
     * MyAccountVewCase constructor.
     */
    public function __construct(UserAccountQuery $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param MyAccountRequest $request
     *
     * @return ImmutableUserInterface|null
     */
    public function execute($request)
    {
        return $this->repository->execute(
            $request->issuer()
        );
    }
}
