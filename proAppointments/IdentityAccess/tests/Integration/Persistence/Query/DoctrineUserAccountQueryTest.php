<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Application\Service\Query\UserAccountQuery;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group doctrine
 */
class DoctrineUserAccountQueryTest extends KernelTestCase
{
    use UserFixtureBehavior;

    /** @var UserAccountQuery|null */
    private $userAccountQuery;

    private $entityManager;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->userAccountQuery = $kernel->getContainer()
            ->get('test.ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Query\UserAccountQuery');

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager');
    }

    /** @test */
    public function canLoadAUserAccount(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->pupulateDatabase($user);

        $userFromDatabase = $this->userAccountQuery->execute($id);

        $this->assertEquals($user->id()->toString(), $userFromDatabase->id());
    }

    /** @test */
    public function querying_by_user_id_return_a_null_value(): void
    {
        self::assertNull(
            $this->userAccountQuery->execute(UserId::generate())
        );
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
        $this->userAccountQuery = null;
        parent::tearDown();
    }
}
