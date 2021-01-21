<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity;

final class ContactInformation
{
    /** @var UserEmail */
    private $email;

    /** @var MobileNumber */
    private $mobileNumber;

    /**
     * ContactInformation constructor.
     */
    public function __construct(UserEmail $email, MobileNumber $mobileNumber = null)
    {
        $this->email = $email;
        $this->mobileNumber = null === $mobileNumber ? MobileNumber::asUnknown() : $mobileNumber;
    }

    public function changeMobileNumber(MobileNumber $mobileNumber): ContactInformation
    {
        return new ContactInformation(
            $this->email(),
            $mobileNumber
        );
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function mobileNumber(): MobileNumber
    {
        return $this->mobileNumber;
    }

    public function equals(ContactInformation $contactInformation): bool
    {
        return $this->email->equals($contactInformation->email)
            && $this->mobileNumber->equals($contactInformation->mobileNumber);
    }
}
