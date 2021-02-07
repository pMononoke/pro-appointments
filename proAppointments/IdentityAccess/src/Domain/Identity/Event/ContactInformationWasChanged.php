<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity\Event;

use DateTimeImmutable;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;

class ContactInformationWasChanged
{
    private $userId;

    private $contactEmail;

    private $contactMobileNumber;

    private $occurredOn;

    public function __construct(UserId $userId, UserEmail $contactEmail, MobileNumber $mobileNumber)
    {
        $this->userId = $userId;
        $this->contactEmail = $contactEmail;
        $this->contactMobileNumber = $mobileNumber;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return UserEmail
     */
    public function contactEmail(): UserEmail
    {
        return $this->contactEmail;
    }

    /**
     * @return MobileNumber
     */
    public function contactMobileNumber(): MobileNumber
    {
        return $this->contactMobileNumber;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function toPayload(): array
    {
        return [
            'userId' => $this->userId->toString(),
            'contact_email' => $this->contactEmail->toString(),
            'contact_mobile_number' => $this->contactMobileNumber->toString(),
        ];
    }
}
