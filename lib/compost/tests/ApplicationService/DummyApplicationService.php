<?php

declare(strict_types=1);

namespace CompostDDD\Tests\ApplicationService;

use CompostDDD\ApplicationService\ApplicationService;

class DummyApplicationService implements ApplicationService
{
    /**
     * @param object $request
     *
     * @return mixed
     */
    public function execute(object $request)
    {
        return;
    }
}
