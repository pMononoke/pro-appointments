<?php

declare(strict_types=1);

namespace CompostDDD\ApplicationService;

/**
 * Interface ApplicationService.
 */
interface ApplicationService
{
    /**
     * @return mixed
     */
    public function execute(object $request);
}
