<?php

declare(strict_types=1);

namespace CompostDDD\EventPersistence;

class EventPersistence
{
    /** @var object */
    private $repository;

    /**
     * EventPersistence constructor.
     *
     * @param object $repository
     */
    public function __construct(object $repository)
    {
        $this->repository = $repository;
    }

    public function append(object $event): void
    {
        $this->repository->append($event);
    }
}
