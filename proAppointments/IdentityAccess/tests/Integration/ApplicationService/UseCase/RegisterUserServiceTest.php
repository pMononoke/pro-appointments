<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use CompostDDD\ApplicationService\TransationalApplicationServiceFactory;
use ProAppointments\IdentityAccess\Application\UserUseCase\RegisterUserRequest;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Tests\DataFixtures\IrrelevantUserFixtureBehavior;

class RegisterUserServiceTest extends UserServiceTestCase
{
    use IrrelevantUserFixtureBehavior;

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

        $this->userRepository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter');

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

    /**
     * @test
     * @expectedException \ProAppointments\IdentityAccess\Domain\Identity\Exception\UserException
     */
    public function register_service_throw_exception_if_email_already_exist(): void
    {
        $user = $this->generateUserAggregate();
        $this->userRepository->register($user);

        $applicationRequest = new RegisterUserRequest(
            //$id = UserId::generate(),
            $user->id(),
            //$email = UserEmail::fromString('irrelevant@example.com'),
            $user->email(),
            //UserPassword::fromString('irrelevant'),
            $user->password(),
            //FirstName::fromString('pippo'),
            $user->person()->name()->firstName(),
            //LastName::fromString('pluto'),
            $user->person()->name()->lastName(),
            //MobileNumber::fromString('+39-5555555')
            $user->person()->contactInformation()->mobileNumber()
        );

        $this->txApplicationService->execute($applicationRequest);

        //$userFromDatabase = $this->retrieveUserById($id);
        //$this->assertTrue($userFromDatabase->id()->equals($id));
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
