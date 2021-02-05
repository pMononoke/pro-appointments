<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity;

final class FullName
{
    private $firstName;
    private $lastName;

    public function __construct(FirstName $firstName, LastName $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function firstName(): ?FirstName //TODO embeddable issue
    {
        return $this->firstName;
    }

    public function lastName(): ?LastName //TODO embeddable issue
    {
        return $this->lastName;
    }

    public function withFirstName(FirstName $firstName): FullName
    {
        return new self($firstName, $this->lastName);
    }

    public function withLastName(LastName $lastName): FullName
    {
        return new self($this->firstName, $lastName);
    }

    public function equals(FullName $fullName): bool
    {
        return $this->firstName->equals($fullName->firstName)
            && $this->lastName->equals($fullName->lastName);
    }
}
