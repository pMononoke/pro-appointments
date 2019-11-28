<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

use CompostDDD\Aggregate\AggregateBehaviour;
use ProAppointments\IdentityAccess\Domain\User\Event\AccessCredentialsWasChanged;
use ProAppointments\IdentityAccess\Domain\User\Event\PersonalNameWasChanged;
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

        $user->recordThat(
            new UserWasRegistered($id, $email)
        );

        return $user;
    }

    public function changePersonalName(FullName $personalName): void
    {
        $this->person->changeName($personalName);

        $this->recordThat(
            new PersonalNameWasChanged($this->id, $this->person()->name()->firstName(), $this->person()->name()->lastName())
        );
    }

    public function changeAccessCredentials(UserPassword $password): void
    {
        $this->password = $password;

        $this->recordThat(
            new AccessCredentialsWasChanged($this->id, $this->password)
        );
    }

    public function delete(): void
    {
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
