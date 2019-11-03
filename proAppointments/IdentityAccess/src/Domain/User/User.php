<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

class User
{
    /** @var UserId */
    private $id;

    /** @var UserEmail */
    private $email;

    /** @var UserPassword */
    private $password;

    /** @var FullName|null */
    private $personalName;

    /**
     * User constructor.
     *
     * @param UserId $id
     */
    private function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public static function register(UserId $id, UserEmail $email, UserPassword $password, ?FullName $fullName = null): User
    {
        $user = new User($id);
        $user->email = $email;
        $user->password = $password;
        $user->personalName = $fullName;

        return $user;
    }

    public function changePersonalName(FullName $personalName): void
    {
        $this->personalName = $personalName;
    }

    /**
     * @param User $other
     *
     * @return bool
     */
    public function sameIdentityAs(User $other): bool
    {
        return $this->id->equals($other->id());
    }

    /**
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->id;
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
     * @return FullName|null
     */
    public function personalName(): ?FullName
    {
        return $this->personalName;
    }
}
