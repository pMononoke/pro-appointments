<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use CompostDDD\Time\Clock;
use CompostDDD\Time\TestClock;
use DAMA\DoctrineTestBundle\Doctrine\DBAL\StaticDriver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class ApplicationServiceTestCase extends KernelTestCase
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * @var TestClock
     */
    private $clock;

    /**
     * @before
     */
    protected function setUpApplicationService(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');

        $this->clock = new TestClock();

        // DISABLE DAMA TRANSACTION
        StaticDriver::setKeepStaticConnections(false);
    }

    /**
     * @after
     */
    protected function tearDownApplicationService(): void
    {
        // enable DAMA TRANSACTION
        StaticDriver::setKeepStaticConnections(true);
    }

    protected function clock(): Clock
    {
        return $this->clock;
    }

    protected function generateAggregate(): array
    {
        return [];
    }

    protected function populateDatabase(object $data): void
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush($data);
    }
}
