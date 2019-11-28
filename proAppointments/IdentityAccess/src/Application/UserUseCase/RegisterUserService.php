<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Domain\Identity\UserFactory;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;

class RegisterUserService implements ApplicationService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var UserFactory */
    private $userFactory;

    public function __construct(UserRepository $userRepository, UserFactory $userFactory)
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }

    /**
     * @param RegisterUserRequest $request
     */
    public function execute($request)
    {
        $factory = new UserFactory();

        $user = $factory->buildWithContactInformation(
            $request->userId(),
            $request->email(),
            $request->password(),
            $request->firstName(),
            $request->lastName(),
            $request->mobileNumber()
        );

        $this->userRepository->register($user);

        return;
    }
}
