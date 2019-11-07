<?php

declare(strict_types=1);

namespace CompostDDD\ApplicationService;

/**
 * Interface ApplicationService.
 */
interface ApplicationService
{
    /**
     * @param object $request
     *
     * @return mixed
     */
    public function execute(object $request);
}
