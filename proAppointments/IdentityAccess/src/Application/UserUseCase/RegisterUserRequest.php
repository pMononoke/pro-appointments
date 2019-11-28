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

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function firstName(): FirstName
    {
        return $this->firstName;
    }

    public function lastName(): LastName
    {
        return $this->lastName;
    }

    public function mobileNumber(): MobileNumber
    {
        return $this->mobileNumber;
    }
}
