<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use ProAppointments\IdentityAccess\Application\UserUseCase\ChangePasswordRequest;
use ProAppointments\IdentityAccess\Domain\Identity\Exception\UserNotFound;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Tests\DataFixtures\IrrelevantUserFixtureBehavior;

class ChangePasswordServiceTest extends UserServiceTestCase
{
    use IrrelevantUserFixtureBehavior;

    private $txApplicationService;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->txApplicationService = $kernel->getContainer()
            ->get('test.Identity\Transational\ChangePasswordService');

        parent::setUp();
    }

    /** @test */
    public function canChangeAUserPassword(): void
    {
        $user = $this->generateUserAggregate();
        $this->populateDatabase($user);
        $applicationRequest = new ChangePasswordRequest(
            $user->id()->toString(),
            $plainPassword = 'new changed password'
        );

        $this->txApplicationService->execute($applicationRequest);

        $userFromDatabase = $this->retrieveUserById($user->id());
        $this->assertTrue($userFromDatabase->id()->equals($user->id()));
        $this->assertNotEquals($userFromDatabase->password()->toString(), $user->password()->toString());
    }

    /** @test */
    public function cantChangeAUserPasswordIfUserNotExist(): void
    {
        self::expectException(UserNotFound::class);

        $applicationRequest = new ChangePasswordRequest(
            UserId::generate()->toString(),
            $plainPassword = 'new changed password'
        );

        $this->txApplicationService->execute($applicationRequest);
    }

    protected function tearDown()
    {
        $this->txApplicationService = null;
        parent::tearDown();
    }
}
