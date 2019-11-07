<?php

declare(strict_types=1);

namespace CompostDDD\ApplicationService;

/**
 * Interface TransationalApplicationServiceFactory.
 */
interface TransationalApplicationServiceFactory
{
    /**
     * @param ApplicationService   $applicationService
     * @param TransactionalSession $transactionalSession
     *
     * @return ApplicationService
     */
    public static function createTransationalApplicationService(ApplicationService $applicationService, TransactionalSession $transactionalSession): ApplicationService;
}
