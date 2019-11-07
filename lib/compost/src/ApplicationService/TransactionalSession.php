<?php

declare(strict_types=1);

namespace CompostDDD\ApplicationService;

/**
 * Interface TransactionalSession.
 */
interface TransactionalSession
{
    /**
     * @param callable $operation
     *
     * @return mixed
     */
    public function executeAtomically(callable $operation);
}
