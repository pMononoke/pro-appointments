<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Domain\Identity\ContactInformation;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;

class ChangeContactInformationService implements ApplicationService
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * ChangeContactInformationService constructor.
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ChangeContactInformationRequest $request
     */
    public function execute($request)
    {
        $user = $this->userRepository->ofId($request->userId());

        $user->changeContactInformation(
            new ContactInformation($request->contactEmail(), $request->contactMobileNumber())
        );

        $this->userRepository->save($user);
    }
}
