<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use CompostDDD\ApplicationService\TransationalApplicationServiceFactory;
use ProAppointments\IdentityAccess\Application\UserUseCase\DeleteUserRequest;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Tests\DataFixtures\IrrelevantUserFixtureBehavior;

class DeleteUserServiceTest extends UserServiceTestCase
{
    use IrrelevantUserFixtureBehavior;

    private $applicationService;

    private $transationalSession;

    /** @var TransationalApplicationServiceFactory */
    private $applicationServiceFactory;

    private $txApplicationService;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->applicationService = $kernel->getContainer()
            ->get('test.ProAppointments\IdentityAccess\Application\UserUseCase\DeleteUserService');

        $this->transationalSession = $kernel->getContainer()
            ->get('test.identity.transactional.session');

        $this->applicationServiceFactory = $kernel->getContainer()
            ->get('test.ProAppointments\IdentityAccess\Infrastructure\Factories\ApplicationServiceFactory');

        $this->txApplicationService = $this->applicationServiceFactory->createTransationalApplicationService($this->applicationService, $this->transationalSession);

        parent::setUp();
    }

    /** @test */
    public function can_execute_service_request()
    {
        $user = $this->generateUserAggregate();
        $this->populateDatabase($user);
        $applicationRequest = new DeleteUserRequest(
            $user->id()
        );

        $this->txApplicationService->execute($applicationRequest);

        self::assertTrue($this->isDeleted($user->id()));
    }

    private function isDeleted(UserId $id): bool
    {
        $deleteStatus = false;

        if (null === $this->retrieveUserById($id)) {
            $deleteStatus = true;
        }

        return $deleteStatus;
    }

    protected function tearDown()
    {
        $this->applicationService = null;
        $this->transationalSession = null;
        $this->applicationServiceFactory = null;
        $this->txApplicationService = null;
        parent::tearDown();
    }
}
