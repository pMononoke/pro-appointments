<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\ApplicationService\UseCase;

use ProAppointments\IdentityAccess\Application\UserUseCase\ChangeContactInformationRequest;
use ProAppointments\IdentityAccess\Application\UserUseCase\ChangeContactInformationService;
use ProAppointments\IdentityAccess\Domain\Identity\Exception\UserNotFound;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Tests\Support\Factory\UserFactoryGirl;

class ChangeContactInformationServiceTest extends UserServiceTestCase
{
    private const NEW_EMAIL = 'a-new-email@example.com';
    private const NEW_MOBILE_NUMBER = '+39 333 999999';

    /** @var ChangeContactInformationService|null */
    private $txApplicationService;

    /** @var UserFactoryGirl */
    private $userFactory;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->txApplicationService = $kernel->getContainer()
            ->get('test.Identity\Transational\ChangeContactInformationService');

        $this->userFactory = new UserFactoryGirl();

        parent::setUp();
    }

    /** @test */
    public function canChangeAContactInformation(): void
    {
        $this->populateDatabase(
            $user = $this->userFactory->build()
        );

        $request = new ChangeContactInformationRequest(
            $user->id()->toString(),
            self::NEW_EMAIL,
            self::NEW_MOBILE_NUMBER
        );

        $this->txApplicationService->execute($request);

        $userFromDB = $this->retrieveUserById($user->id());
        self::assertEquals($userFromDB->person()->contactInformation()->email()->toString(), self::NEW_EMAIL);
        self::assertEquals($userFromDB->person()->contactInformation()->mobileNumber()->toString(), self::NEW_MOBILE_NUMBER);
    }

    /** @test */
    public function canChangeAContactEmail(): void
    {
        self::markTestSkipped('not yet implemented');
    }

    /** @test */
    public function canChangeAContactMobileNumber(): void
    {
        self::markTestSkipped('not yet implemented');
    }

    /** @test */
    public function changeAContactInformationShouldFailIfUserNotExist(): void
    {
        self::expectException(UserNotFound::class);

        $request = new ChangeContactInformationRequest(
            UserId::generate()->toString(),
            self::NEW_EMAIL,
            self::NEW_MOBILE_NUMBER
        );

        $this->txApplicationService->execute($request);
    }

    protected function tearDown()
    {
        $this->txApplicationService = null;
        $this->userFactory = null;
        parent::tearDown();
    }
}
