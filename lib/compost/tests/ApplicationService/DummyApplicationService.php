<?php

declare(strict_types=1);

namespace CompostDDD\Tests\ApplicationService;

use CompostDDD\ApplicationService\ApplicationService;

class DummyApplicationService implements ApplicationService
{
    /**
     * @return mixed
     */
    public function execute(object $request)
    {
        return;
    }
}
