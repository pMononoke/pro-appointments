<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Access;

use CompostDDD\Aggregate\AggregateBehaviour;
use ProAppointments\IdentityAccess\Domain\Access\Event\RoleWasProvisioned;

class Role
{
    use AggregateBehaviour;

    private $id;

    private $name;

    private $description;

    public function __construct(RoleId $id, RoleName $name, RoleDescription $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
//        $this->recordThat(
//            new RoleWasProvisioned($this->id, $this->name, $this->description)
//        );
    }

    public function sameIdentityAs(Role $other): bool
    {
        return $this->id->equals($other->id());
    }

    public function id(): RoleId
    {
        return $this->id;
    }

    public function name(): RoleName
    {
        return $this->name;
    }

    public function description(): ?RoleDescription
    {
        return $this->description;
    }
}
