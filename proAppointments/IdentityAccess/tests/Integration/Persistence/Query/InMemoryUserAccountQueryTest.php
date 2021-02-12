<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Query;

use ProAppointments\IdentityAccess\Application\Service\Query\UserAccountQuery;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUserAccountQuery;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryUserAccountQueryTest extends KernelTestCase
{
    use UserFixtureBehavior;

    /** @var UserAccountQuery */
    private $userAccountQuery;

    /** @var InMemoryUserRepository */
    private $repository;

    protected function setUp()
    {
        $this->repository = new InMemoryUserRepository();

        $this->userAccountQuery = new InMemoryUserAccountQuery(
            $this->repository
        );
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
        $this->repository->register($data);
    }

    protected function tearDown()
    {
        $this->repository = null;
        $this->userAccountQuery = null;
        parent::tearDown();
    }
}
