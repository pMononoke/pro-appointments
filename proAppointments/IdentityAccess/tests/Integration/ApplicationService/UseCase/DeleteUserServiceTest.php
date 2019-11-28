<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use CompostDDD\ApplicationService\TransationalApplicationServiceFactory;
use ProAppointments\IdentityAccess\Application\UserUseCase\DeleteUserRequest;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class DeleteUserServiceTest extends UserServiceTestCase
{
    private $applicationService;

    private $transationalSession;

    /** @var TransationalApplicationServiceFactory */
    private $applicationServiceFactory;

    private $txApplicationService;

    protected function setUp()
    {
        $kernel = parent::bootKernel();

        $this->applicationService = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Application\UserUseCase\DeleteUserService');

        $this->transationalSession = $kernel->getContainer()
            ->get('identity.transactional.session');

        $this->applicationServiceFactory = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Factories\ApplicationServiceFactory');

        $this->txApplicationService = $this->applicationServiceFactory->createTransationalApplicationService($this->applicationService, $this->transationalSession);

        parent::setUp();
    }

    /** @test */
    public function can_execute_service_request()
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->populateDatabase($user);
        $applicationRequest = new DeleteUserRequest(
            $id
        );

        $this->txApplicationService->execute($applicationRequest);

        self::assertTrue($this->isDeleted($id));
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
