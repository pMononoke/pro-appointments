<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use CompostDDD\ApplicationService\TransationalApplicationServiceFactory;
use ProAppointments\IdentityAccess\Application\UserUseCase\RegisterUserRequest;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\LastName;
use ProAppointments\IdentityAccess\Domain\User\MobileNumber;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

class RegisterUserServiceTest extends UserServiceTestCase
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
            ->get('ProAppointments\IdentityAccess\Application\UserUseCase\RegisterUserService');

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
        $applicationRequest = new RegisterUserRequest(
            $id = UserId::generate(),
            $email = UserEmail::fromString('irrelevant@example.com'),
            UserPassword::fromString('irrelevant'),
            FirstName::fromString('pippo'),
            LastName::fromString('pluto'),
            MobileNumber::fromString('+39-5555555')
        );

        $this->txApplicationService->execute($applicationRequest);

        $userFromDatabase = $this->retrieveUserById($id);
        $this->assertTrue($userFromDatabase->id()->equals($id));
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
