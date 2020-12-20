<?php

declare(strict_types=1);

namespace CompostDDD\Tests\Aggregate;

use PHPUnit\Framework\TestCase;

class AggregateBehaviourTest extends TestCase
{
    /** @test */
    public function can_record_and_release_one_event(): void
    {
        $aggregate = new DummyAggregate();

        $aggregate->task();
        $outputEvents = $aggregate->releaseEvents();

        self::assertNotEmpty($outputEvents);
        self::assertEquals(1, \count($outputEvents));
    }

    /** @test */
    public function can_record_and_release_multiple_events(): void
    {
        $aggregate = new DummyAggregate();

        $aggregate->task();
        $aggregate->task();
        $aggregate->task();
        $outputEvents = $aggregate->releaseEvents();

        self::assertNotEmpty($outputEvents);
        self::assertEquals(3, \count($outputEvents));
    }
}
