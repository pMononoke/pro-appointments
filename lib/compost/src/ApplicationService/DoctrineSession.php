<?php

declare(strict_types=1);

namespace CompostDDD\ApplicationService;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineSession implements TransactionalSession
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * DoctrineSession constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param callable $operation
     *
     * @return mixed
     */
    public function executeAtomically(callable $operation)
    {
        return $this->entityManager->transactional($operation);
    }
}
