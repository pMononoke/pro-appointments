<?php

declare(strict_types=1);

namespace CompostDDD\Tests\ApplicationService;

use CompostDDD\ApplicationService\ApplicationService;
use CompostDDD\ApplicationService\TransactionalApplicationService;
use CompostDDD\ApplicationService\TransactionalSession;
use CompostDDD\ApplicationService\TransationalApplicationServiceFactory;

class DummyTransationalApplicationServiceFactory implements TransationalApplicationServiceFactory
{
    /**
     * @param ApplicationService   $applicationService
     * @param TransactionalSession $transactionalSession
     *
     * @return ApplicationService
     */
    public static function createTransationalApplicationService(ApplicationService $applicationService, TransactionalSession $transactionalSession): ApplicationService
    {
        $transationalApplication = new TransactionalApplicationService($transactionalSession, $applicationService);

        return $transationalApplication;
    }
}
