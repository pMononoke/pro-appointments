<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\ViewModel;

use ProAppointments\IdentityAccess\Domain\Identity\User;

class UserAccount implements ImmutableUserInterface
{
    /** @var User */
    private $user;

    /**
     * UserAccount constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function id(): string
    {
        return $this->user->id()->toString();
    }

    public function email(): string
    {
        return $this->user->email()->toString();
    }

    /**
     * @return string|null
     */
    public function firstName()
    {
        return $this->user->person()->name()->firstName()->toString();
    }

    /**
     * @return string|null
     */
    public function lastName()
    {
        return $this->user->person()->name()->lastName()->toString();
    }

    public function contactEmail(): string
    {
        return $this->user->person()->contactInformation()->email()->toString();
    }

    /**
     * @return string|null
     */
    public function contactNumber()
    {
        return $this->user->person()->contactInformation()->mobileNumber()->toString();
    }
}
