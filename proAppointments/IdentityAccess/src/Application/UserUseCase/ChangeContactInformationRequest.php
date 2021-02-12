<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ServiceRequest;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class ChangeContactInformationRequest implements ServiceRequest
{
    /** @var UserId */
    private $userId;

    /** @var UserEmail */
    private $contactEmail;

    /** @var MobileNumber */
    private $contactMobileNumber;

    /**
     * ChangeContactInformationRequest constructor.
     */
    public function __construct(string $userId, string $contactEmail, string $contactMobileNumber)
    {
        $this->userId = UserId::fromString($userId);
        $this->contactEmail = UserEmail::fromString($contactEmail);
        $this->contactMobileNumber = MobileNumber::fromString($contactMobileNumber);
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function contactEmail(): UserEmail
    {
        return $this->contactEmail;
    }

    public function contactMobileNumber(): MobileNumber
    {
        return $this->contactMobileNumber;
    }
}
