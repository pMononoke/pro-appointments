<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Domain\Service\PasswordEncoder;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;
use ProAppointments\IdentityAccess\Domain\User\UserRepository;

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

        // TODO implement real password encoder service.
        //$password = $this->passwordEncoder->encode($request->plainPassword());

        $password = UserPassword::fromString($request->plainPassword());

        $user->changeAccessCredentials($password);

        $this->userRepository->save($user);
    }
}
