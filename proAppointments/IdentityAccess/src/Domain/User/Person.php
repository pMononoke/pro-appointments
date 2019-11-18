<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User;

class Person
{
    /** @var UserId */
    private $userId;

    /** @var FullName */
    private $name;

    /** @var ContactInformation */
    private $contactInformation;

    /**
     * Person constructor.
     */
    public function __construct(UserId $userId, FullName $name, ContactInformation $contactInformation)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->contactInformation = $contactInformation;
    }

    public function changeContactInformation(ContactInformation $contactInformation): void
    {
        $this->contactInformation = $contactInformation;
        // TODO DOMAIN EVENT
    }

    public function changeName(FullName $name)
    {
        $this->name = $name;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function name(): FullName
    {
        return $this->name;
    }

    public function contactInformation(): ContactInformation
    {
        return $this->contactInformation;
    }

    public function equals(Person $person): bool
    {
        return $this->userId->equals($person->userId)
            && $this->name()->equals($person->name)
            && $this->contactInformation()->equals($person->contactInformation);
    }
}
