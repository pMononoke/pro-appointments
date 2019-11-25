<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Access;

use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRemoveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRetrieveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound;

interface RoleRepository
{
    public function nextIdentity(): RoleId;

    /**
     * @throws RoleAlreadyExist
     * @throws ImpossibleToSaveRole
     */
    public function add(Role $role): void;

    /**
     * @throws RoleNotFound
     * @throws ImpossibleToRetrieveRole
     */
    public function ofId(RoleId $roleId): Role;

    /**
     * @throws RoleNotFound
     * @throws ImpossibleToSaveRole
     */
    public function update(Role $role): void;

    /**
     * @throws ImpossibleToRemoveRole
     */
    public function remove(Role $role): void;
}
