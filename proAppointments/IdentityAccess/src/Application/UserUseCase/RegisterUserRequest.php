<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ServiceRequest;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\LastName;
use ProAppointments\IdentityAccess\Domain\User\MobileNumber;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

class RegisterUserRequest implements ServiceRequest
{
    /** @var UserId */
    private $userId;

    /** @var UserEmail */
    private $email;

    /** @var UserPassword */
    private $password;

    /** @var FirstName */
    private $firstName;

    /** @var LastName */
    private $lastName;

    /** @var MobileNumber */
    private $mobileNumber;

    /**
     * RegisterUserRequest constructor.
     *
     * @param UserId       $userId
     * @param UserEmail    $email
     * @param UserPassword $password
     * @param FirstName    $firstName
     * @param LastName     $lastName
     * @param MobileNumber $mobileNumber
     */
    public function __construct(UserId $userId, UserEmail $email, UserPassword $password, FirstName $firstName, LastName $lastName, MobileNumber $mobileNumber)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return UserEmail
     */
    public function email(): UserEmail
    {
        return $this->email;
    }

    /**
     * @return UserPassword
     */
    public function password(): UserPassword
    {
        return $this->password;
    }

    /**
     * @return FirstName
     */
    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    /**
     * @return LastName
     */
    public function lastName(): LastName
    {
        return $this->lastName;
    }

    /**
     * @return MobileNumber
     */
    public function mobileNumber(): MobileNumber
    {
        return $this->mobileNumber;
    }
}
