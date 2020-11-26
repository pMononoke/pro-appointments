<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group doctrine
 */
class DoctrineUserQueryTest extends KernelTestCase
{
    use UserFixtureBehavior;

    private $userQuery;

    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->userQuery = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query\UserQuery');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');
    }

    /** @test */
    public function can_find_a_user_by_user_id(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->pupulateDatabase($user);

        $userFromDatabase = $this->userQuery->execute($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
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
        $this->userQuery = null;
        parent::tearDown();
    }
}
