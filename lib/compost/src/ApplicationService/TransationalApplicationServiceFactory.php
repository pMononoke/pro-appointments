<?php

declare(strict_types=1);

namespace CompostDDD\ApplicationService;

/**
 * Interface TransationalApplicationServiceFactory.
 */
interface TransationalApplicationServiceFactory
{
    public static function createTransationalApplicationService(ApplicationService $applicationService, TransactionalSession $transactionalSession): ApplicationService;
}
