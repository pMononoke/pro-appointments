<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

use CompostDDD\Aggregate\AggregateBehaviour;

class User
{
    use AggregateBehaviour;

    /** @var UserId */
    private $id;

    /** @var UserEmail */
    private $email;

    /** @var UserPassword */
    private $password;

    /** @var Person */
    private $person;

    /**
     * User constructor.
     *
     * @param UserId $id
     */
    private function __construct(UserId $id)
    {
        $this->id = $id;
    }

    /**
     * @param UserId       $id
     * @param UserEmail    $email
     * @param UserPassword $password
     * @param Person       $person
     *
     * @return User
     */
    public static function register(UserId $id, UserEmail $email, UserPassword $password, Person $person): User
    {
        $user = new User($id);
        $user->email = $email;
        $user->password = $password;
        $user->person = $person;

        //TODO DOMAIN EVENT

        return $user;
    }

    /**
     * @param FullName $personalName
     */
    public function changePersonalName(FullName $personalName): void
    {
        $this->person->changeName($personalName);
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
     * @return Person
     */
    public function person(): Person
    {
        return $this->person;
    }
}
