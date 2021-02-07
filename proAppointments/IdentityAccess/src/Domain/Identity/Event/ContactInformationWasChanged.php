<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity\Event;

use DateTimeImmutable;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class ContactInformationWasChanged
{
    /** @var UserId */
    private $userId;

    /** @var UserEmail */
    private $contactEmail;

    /** @var MobileNumber */
    private $contactMobileNumber;

    /** @var DateTimeImmutable */
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

    public function contactEmail(): UserEmail
    {
        return $this->contactEmail;
    }

    public function contactMobileNumber(): MobileNumber
    {
        return $this->contactMobileNumber;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    /**
     * @return array<mixed>
     */
    public function toPayload(): array
    {
        return [
            'userId' => $this->userId->toString(),
            'contact_email' => $this->contactEmail->toString(),
            'contact_mobile_number' => $this->contactMobileNumber->toString(),
        ];
    }
}
