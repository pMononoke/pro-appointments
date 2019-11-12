<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

use CompostDDD\Aggregate\AggregateBehaviour;
use ProAppointments\IdentityAccess\Domain\User\Event\UserWasDeleted;
use ProAppointments\IdentityAccess\Domain\User\Event\UserWasRegistered;

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
     */
    private function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public static function register(UserId $id, UserEmail $email, UserPassword $password, Person $person): User
    {
        $user = new User($id);
        $user->email = $email;
        $user->password = $password;
        $user->person = $person;

        //TODO DOMAIN EVENT
        $user->recordThat(
            new UserWasRegistered($id, $email)
        );

        return $user;
    }

    public function changePersonalName(FullName $personalName): void
    {
        $this->person->changeName($personalName);
    }

    public function delete(): void
    {
        //TODO DOMAIN EVENT
        $this->recordThat(
            new UserWasDeleted($this->id)
        );
    }

    public function sameIdentityAs(User $other): bool
    {
        return $this->id->equals($other->id());
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function person(): Person
    {
        return $this->person;
    }
}
