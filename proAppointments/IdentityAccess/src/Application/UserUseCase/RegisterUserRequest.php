<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\UserUseCase;

use CompostDDD\ApplicationService\ServiceRequest;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;

class RegisterUserRequest implements ServiceRequest
{
    /** @var UserId|null */
    private $userId;

    /** @var UserEmail */
    private $email;

    /** @var UserPassword */
    private $password;

    /** @var FirstName|null */
    private $firstName;

    /** @var LastName|null */
    private $lastName;

    /** @var MobileNumber|null */
    private $mobileNumber;

    /**
     * RegisterUserRequest constructor.
     */
    public function __construct(string $email, string $password, string $firstName = null, string $lastName = null, string $mobileNumber = null, string $userId = null)
    {
        $this->userId = UserId::fromString($userId);
        $this->email = UserEmail::fromString($email);
        $this->password = UserPassword::fromString($password);
        $this->firstName = null === $firstName ? null : FirstName::fromString($firstName);
        $this->lastName = null === $lastName ? null : LastName::fromString($lastName);
        $this->mobileNumber = null === $mobileNumber ? null : MobileNumber::fromString($mobileNumber);
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
