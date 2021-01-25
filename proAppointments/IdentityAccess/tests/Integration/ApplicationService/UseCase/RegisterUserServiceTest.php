<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use ProAppointments\IdentityAccess\Application\UserUseCase\RegisterUserRequest;
use ProAppointments\IdentityAccess\Domain\Identity\Exception\UserAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Identity\Exception\UserException;
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

    private $txApplicationService;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->txApplicationService = $kernel->getContainer()
            ->get('test.Identity\Transational\RegisterUserService');

        parent::setUp();
    }

    /** @test */
    public function can_register_a_new_user(): void
    {
        $id = UserId::generate();

        $applicationRequest = new RegisterUserRequest(
            $email = UserEmail::fromString('irrelevant@example.com')->toString(),
            UserPassword::fromString('irrelevant')->toString(),
            FirstName::fromString('pippo')->toString(),
            LastName::fromString('pluto')->toString(),
            MobileNumber::fromString('+39-5555555')->toString(),
            $id->toString(),
        );

        $this->txApplicationService->execute($applicationRequest);

        $userFromDatabase = $this->retrieveUserById($id);
        $this->assertTrue($userFromDatabase->id()->equals($id));
    }

    /** @test */
    public function registrationShouldFailOnDuplicateUserEmail(): void
    {
        self::expectException(UserException::class);

        $user = $this->generateUserAggregate();
        $this->userRepository->register($user);

        $duplicatedUserEmailapplicationRequest = new RegisterUserRequest(
            $user->email()->toString(),
            $user->password()->toString(),
            $user->person()->name()->firstName()->toString(),
            $user->person()->name()->lastName()->toString(),
            $user->person()->contactInformation()->mobileNumber()->toString(),
            UserId::generate()->toString(),
        );

        $this->txApplicationService->execute($duplicatedUserEmailapplicationRequest);
    }

    /** @test */
    public function registrationShouldFailOnDuplicateUserId(): void
    {
        self::expectException(UserAlreadyExist::class);

        $user = $this->generateUserAggregate();
        $this->userRepository->register($user);

        $duplicatedUserIdApplicationRequest = new RegisterUserRequest(
            UserEmail::fromString('other@email.com')->toString(),
            $user->password()->toString(),
            $user->person()->name()->firstName()->toString(),
            $user->person()->name()->lastName()->toString(),
            $user->person()->contactInformation()->mobileNumber()->toString(),
            $user->id()->toString(),
        );

        $this->txApplicationService->execute($duplicatedUserIdApplicationRequest);
    }

    protected function tearDown()
    {
        $this->txApplicationService = null;
        parent::tearDown();
    }
}
