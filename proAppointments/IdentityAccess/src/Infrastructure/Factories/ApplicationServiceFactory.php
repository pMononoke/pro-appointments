<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Factories;

use CompostDDD\ApplicationService\ApplicationService;
use CompostDDD\ApplicationService\TransactionalApplicationService;
use CompostDDD\ApplicationService\TransactionalSession;
use CompostDDD\ApplicationService\TransationalApplicationServiceFactory;

class ApplicationServiceFactory implements TransationalApplicationServiceFactory
{
    public static function createTransationalApplicationService(ApplicationService $applicationService, TransactionalSession $transactionalSession): ApplicationService
    {
        return new TransactionalApplicationService($transactionalSession, $applicationService);
    }
}
