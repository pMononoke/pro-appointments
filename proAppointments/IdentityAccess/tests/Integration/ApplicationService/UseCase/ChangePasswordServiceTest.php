<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use CompostDDD\ApplicationService\TransationalApplicationServiceFactory;
use ProAppointments\IdentityAccess\Application\UserUseCase\ChangePasswordRequest;

class ChangePasswordServiceTest extends UserServiceTestCase
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
            ->get('ProAppointments\IdentityAccess\Application\UserUseCase\ChangePasswordService');

        $this->transationalSession = $kernel->getContainer()
            ->get('identity.transactional.session');

        $this->applicationServiceFactory = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Factories\ApplicationServiceFactory');

        $this->txApplicationService = $this->applicationServiceFactory->createTransationalApplicationService($this->applicationService, $this->transationalSession);

        parent::setUp();
    }

    /** @test */
    public function can_execute_service_request(): void
    {
        list($id, $user) = $this->generateUserAggregate();
        $this->populateDatabase($user);
        $applicationRequest = new ChangePasswordRequest(
            $id,
            $plainPassword = 'new changed password'
        );

        $this->txApplicationService->execute($applicationRequest);

        $userFromDatabase = $this->retrieveUserById($id);
        $this->assertTrue($userFromDatabase->id()->equals($id));
        // Todo remove after real password encoder implementation.
        $this->assertEquals($userFromDatabase->password()->toString(), $plainPassword);
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
