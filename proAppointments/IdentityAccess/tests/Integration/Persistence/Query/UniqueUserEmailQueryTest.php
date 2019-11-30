<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmailQuery;
use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UniqueUserEmailQueryTest extends KernelTestCase
{
    use UserFixtureBehavior;

    /** @var uniqueUserEmailQuery */
    private $uniqueUserEmailQuery;

    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->uniqueUserEmailQuery = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query\UniqueUserEmailQuery');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');
    }

    /** @test */
    public function can_return_not_unique_email_if_email_exist(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->pupulateDatabase($user);

        $this->assertFalse($this->uniqueUserEmailQuery->execute($user->email()));
    }

    /** @test */
    public function can_return_unique_email_if_email_not_exist(): void
    {
        $this->assertTrue($this->uniqueUserEmailQuery->execute(UserEmail::fromString('unknown@example.com')));
    }

    private function pupulateDatabase(object $data): void
    {
        $this->writeData($data);
    }

    protected function writeData(object $data): void
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    protected function tearDown()
    {
        $this->entityManager = null;
        $this->uniqueUserEmailQuery = null;
        parent::tearDown();
    }
}
