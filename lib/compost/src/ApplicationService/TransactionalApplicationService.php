<?php

declare(strict_types=1);

namespace CompostDDD\ApplicationService;

class TransactionalApplicationService implements ApplicationService
{
    /** @var TransactionalSession */
    private $databaseSession;

    /** @var ApplicationService */
    private $applicationService;

    /**
     * TransactionalApplicationService constructor.
     *
     * @param TransactionalSession $databaseSession
     * @param ApplicationService   $applicationService
     */
    public function __construct(TransactionalSession $databaseSession, ApplicationService $applicationService)
    {
        $this->databaseSession = $databaseSession;
        $this->applicationService = $applicationService;
    }

    /**
     * @param null $request
     *
     * @return mixed
     */
    public function execute($request = null)
    {
        if (empty($this->service)) {
            throw new \LogicException('A use case must be specified');
        }

        $operation = function () use ($request) {
            return $this->applicationService->execute($request);
        };

        return $this->databaseSession->executeAtomically($operation);
    }
}
