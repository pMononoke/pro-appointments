<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ApplicationService;
use ProAppointments\IdentityAccess\Domain\Identity\Exception\UserException;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserFactory;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Domain\Identity\UserRepository;
use ProAppointments\IdentityAccess\Domain\Service\DomainRegistry;
use ProAppointments\IdentityAccess\Domain\Service\PasswordEncoder;

class RegisterUserService implements ApplicationService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var UserFactory */
    private $userFactory;

    /** @var DomainRegistry */
    private $domainRegistry;

    /** @var PasswordEncoder */
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserFactory $userFactory, DomainRegistry $identityDomainRegistry)
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
        $this->domainRegistry = $identityDomainRegistry;
        $this->passwordEncoder = $identityDomainRegistry->passwordEncoder();
    }

    /**
     * @param RegisterUserRequest $request
     */
    public function execute($request): void
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

        $password = $this->encodeUserPassword($user, $request->password()->toString());

        $user->changeAccessCredentials($password);
        $this->userRepository->register($user);
    }

    private function isUniqueEmail(UserEmail $userEmail): bool
    {
        $uniqueUserEmailService = $this->domainRegistry->uniqueUserEmail();

        return ($uniqueUserEmailService)($userEmail);
    }

    private function encodeUserPassword(User $user, string $password): UserPassword
    {
        return $this->passwordEncoder->encode($user, $password);
    }
}
