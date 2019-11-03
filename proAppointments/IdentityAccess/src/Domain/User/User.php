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
    private $fullName;

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
        $user->fullName = $fullName;

        return $user;
    }

    public function changePersonalName(FullName $aPersonalName)
    {
        $this->fullName = $aPersonalName;
    }
}
