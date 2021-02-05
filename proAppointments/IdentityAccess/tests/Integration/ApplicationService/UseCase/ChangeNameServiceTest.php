<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use ProAppointments\IdentityAccess\Application\UserUseCase\ChangeNameRequest;
use ProAppointments\IdentityAccess\Domain\Identity\Exception\UserNotFound;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Tests\DataFixtures\IrrelevantUserFixtureBehavior;

class ChangeNameServiceTest extends UserServiceTestCase
{
    use IrrelevantUserFixtureBehavior;

    private $txApplicationService;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->txApplicationService = $kernel->getContainer()
            ->get('test.Identity\Transational\ChangeNameService');

        parent::setUp();
    }

    /** @test */
    public function canChangeTheUserPersonalName(): void
    {
        $user = $this->generateUserAggregate();
        $this->populateDatabase($user);
        $applicationRequest = new ChangeNameRequest(
            $user->id()->toString(),
            $firstName = 'new first name',
            $lastName = 'new last name'
        );

        $this->txApplicationService->execute($applicationRequest);

        $userFromDatabase = $this->retrieveUserById($user->id());
        $this->assertTrue($userFromDatabase->id()->equals($user->id()));
        $this->assertEquals($userFromDatabase->person()->name()->firstName()->toString(), $firstName);
        $this->assertEquals($userFromDatabase->person()->name()->lastName()->toString(), $lastName);
    }

    /** @test */
    public function canChangeTheUserPersonalNameIfUserNotExist(): void
    {
        self::expectException(UserNotFound::class);
        $applicationRequest = new ChangeNameRequest(
            UserId::generate()->toString(),
            $firstName = 'new first name',
            $lastName = 'new last name'
        );

        $this->txApplicationService->execute($applicationRequest);
    }

    protected function tearDown()
    {
        $this->txApplicationService = null;
        parent::tearDown();
    }
}
