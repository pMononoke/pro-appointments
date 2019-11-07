<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Domain\User\UserFactory;
use ProAppointments\IdentityAccess\Domain\User\UserRepository;

class RegisterUserService implements ApplicationService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var UserFactory */
    private $userFactory;

    /**
     * RegisterUserService constructor.
     *
     * @param UserRepository $userRepository
     * @param UserFactory    $userFactory
     */
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
