<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Notification;

use ProAppointments\IdentityAccess\Infrastructure\Notification\EventStore;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineEventStoreTest extends KernelTestCase
{
    private $eventStore;

    private $doctrineConnection;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->eventStore = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Notification\DoctrineEventStore');
        $this->doctrineConnection = $kernel->getContainer()
            ->get('test.doctrine.dbal.connection');
    }

    /** @test */
    public function can_persist_and_retrieve_a_event(): void
    {
        self::markTestSkipped('Fragile test.  Autogenerated ID\'s are unreliable for this test. ');
        /** @var EventStore $eventStore */
        $eventStore = $this->eventStore;

        $dummyEvent = new DummyEvent('1', 'irrelevant@example.com');

        $eventStore->append($dummyEvent);
        $eventsFromDatabase = $eventStore->allStoredEventsSince(0);

        $this->assertEquals(1, \count($eventsFromDatabase));
    }

    /** @test */
    public function can_retrieve_all_event(): void
    {
        self::markTestSkipped('Fragile test.  Autogenerated ID\'s are unreliable for this test. ');
        /** @var EventStore $eventStore */
        $eventStore = $this->eventStore;

        $firstDummyEvent = new DummyEvent('1', 'irrelevant@example.com');
        $secondDummyEvent = new DummyEvent('2', 'irrelevant@example.com');

        $eventStore->append($firstDummyEvent);
        $eventStore->append($secondDummyEvent);
        $eventsFromDatabase = $eventStore->allStoredEventsSince(0);

        $this->assertEquals(2, \count($eventsFromDatabase));
    }

    /** @test */
    public function can_retrieve_all_event_since(): void
    {
        self::markTestSkipped();
        /** @var EventStore $eventStore */
        $eventStore = $this->eventStore;

        $firstDummyEvent = new DummyEvent('1', 'irrelevant@example.com');
        $secondDummyEvent = new DummyEvent('2', 'irrelevant@example.com');
        $thirdDummyEvent = new DummyEvent('3', 'irrelevant@example.com');

        $eventStore->append($firstDummyEvent);
        $eventStore->append($secondDummyEvent);
        $eventStore->append($thirdDummyEvent);
        $eventsFromDatabase = $eventStore->allStoredEventsSince(1);

        $this->assertEquals(2, \count($eventsFromDatabase));
    }

    private function reset_table_autoincrement()
    {
        $connection = $this->doctrineConnection;

        // If you are using auto-increment IDs, you might want to reset them. It is usually better to purge/reset
        // things at the beginning of a test so that in case of a failure, you are not ending up in a broken state.
        // With PostgreSQL:
        //$connection->executeQuery('ALTER SEQUENCE dummy_sequence RESTART');
        // With MySQL:
        $connection->executeQuery('ALTER TABLE ia_domain_event AUTO_INCREMENT = 1');
    }

    protected function tearDown()
    {
        $this->eventStore = null;

        parent::tearDown();
    }
}
