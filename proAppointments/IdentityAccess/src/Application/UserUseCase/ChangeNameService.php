<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Domain\Identity\FullName;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;

class ChangeNameService implements ApplicationService
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ChangeNameRequest $request
     */
    public function execute($request)
    {
        $user = $this->userRepository->ofId($request->userId());

        $user->changePersonalName(
            new FullName($request->firstName(), $request->lastName())
        );

        $this->userRepository->save($user);
    }
}
