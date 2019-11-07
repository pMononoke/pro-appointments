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
     *
     * @param UserId             $userId
     * @param FullName           $name
     * @param ContactInformation $contactInformation
     */
    public function __construct(UserId $userId, FullName $name, ContactInformation $contactInformation)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->contactInformation = $contactInformation;
    }

    /**
     * @param ContactInformation $contactInformation
     */
    public function changeContactInformation(ContactInformation $contactInformation): void
    {
        $this->contactInformation = $contactInformation;
        // TODO DOMAIN EVENT
    }

    /**
     * @param FullName $name
     */
    public function changeName(FullName $name)
    {
        $this->name = $name;
        // TODO DOMAIN EVENT
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return FullName
     */
    public function name(): FullName
    {
        return $this->name;
    }

    /**
     * @return ContactInformation
     */
    public function contactInformation(): ContactInformation
    {
        return $this->contactInformation;
    }

    /**
     * @param Person $person
     *
     * @return bool
     */
    public function equals(Person $person): bool
    {
        return $this->userId->equals($person->userId)
            && $this->name()->equals($person->name)
            && $this->contactInformation()->equals($person->contactInformation);
    }
}
