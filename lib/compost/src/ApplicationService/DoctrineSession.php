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
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     */
    public function executeAtomically(callable $operation)
    {
        return $this->entityManager->transactional($operation);
    }
}
