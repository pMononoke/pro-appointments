<?php

declare(strict_types=1);

namespace CompostDDD\Tests\Aggregate;

use CompostDDD\Aggregate\AggregateBehaviour;

class DummyAggregate
{
    use AggregateBehaviour;

    public function task(): void
    {
        $this->recordThat(new DummyEventObject());
    }
}
