<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Domain\User\UserRepository;

class DeleteUserService implements ApplicationService
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * RegisterUserService constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param DeleteUserRequest $request
     */
    public function execute($request)
    {
        $user = $this->userRepository->ofId($request->userId());

        // TODO method delete() record the event UserWasDeleted
        // comment this row if you don't want to store the event
        //
        $user->delete();

        $this->userRepository->remove($user);

        return;
    }
}
