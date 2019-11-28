<?php

declare(strict_types=1);

namespace CompostDDD\Aggregate;

trait AggregateBehaviour
{
    /**
     * @var object[]
     */
    private $recordedEvents = [];

    protected function recordThat(object $event): void
    {
        $this->recordedEvents[] = $event;
    }

    /**
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $releasedEvents = $this->recordedEvents;
        $this->recordedEvents = [];

        return $releasedEvents;
    }
}
