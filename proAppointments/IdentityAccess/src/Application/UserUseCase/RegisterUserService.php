<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Domain\Identity\Exception\UserException;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserFactory;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;
use ProAppointments\IdentityAccess\Domain\Service\DomainRegistry;

class RegisterUserService implements ApplicationService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var UserFactory */
    private $userFactory;

    /** @var DomainRegistry */
    private $domainRegistry;

    public function __construct(UserRepository $userRepository, UserFactory $userFactory, DomainRegistry $identityDomainRegistry)
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
        $this->domainRegistry = $identityDomainRegistry;
    }

    /**
     * @param RegisterUserRequest $request
     */
    public function execute($request)
    {
        if (!$this->isUniqueEmail($request->email())) {
            //TODO poor text, text message to change in the future.
            throw new UserException('Email exist.|Can not register with this email address.');
        }
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

    private function isUniqueEmail(UserEmail $userEmail): bool
    {
        $uniqueUserEmailService = $this->domainRegistry->uniqueUserEmail();

        return ($uniqueUserEmailService)($userEmail);
    }
}
