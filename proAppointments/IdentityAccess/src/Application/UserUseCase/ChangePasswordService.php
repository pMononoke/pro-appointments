<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;
use ProAppointments\IdentityAccess\Domain\Service\PasswordEncoder;

class ChangePasswordService implements ApplicationService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var PasswordEncoder */
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, PasswordEncoder $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ChangePasswordRequest $request
     */
    public function execute($request)
    {
        $user = $this->userRepository->ofId($request->userId());

        $encodedPassword = $this->passwordEncoder->encode($user, $request->plainPassword());

        $user->changeAccessCredentials($encodedPassword);

        $this->userRepository->save($user);
    }
}
