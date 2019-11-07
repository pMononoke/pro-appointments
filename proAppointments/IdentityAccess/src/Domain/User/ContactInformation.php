<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

final class ContactInformation
{
    /** @var UserEmail */
    private $email;

    /** @var MobileNumber */
    private $mobileNumber;

    /**
     * ContactInformation constructor.
     *
     * @param UserEmail    $email
     * @param MobileNumber $mobileNumber
     */
    public function __construct(UserEmail $email, MobileNumber $mobileNumber)
    {
        $this->email = $email;
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @param MobileNumber $mobileNumber
     *
     * @return ContactInformation
     */
    public function changeMobileNumber(MobileNumber $mobileNumber): ContactInformation
    {
        return new ContactInformation(
            $this->email(),
            $mobileNumber
        );
    }

    /**
     * @return UserEmail
     */
    public function email(): UserEmail
    {
        return $this->email;
    }

    /**
     * @return MobileNumber
     */
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
