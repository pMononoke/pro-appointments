<?php

declare(strict_types=1);

namespace CompostDDD\Tests\ApplicationService;

use CompostDDD\ApplicationService\TransactionalSession;

class DummyTransationalSession implements TransactionalSession
{
    /**
     * @param callable $operation
     *
     * @return mixed
     */
    public function executeAtomically(callable $operation)
    {
        return;
    }
}
