<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter;

use Exception;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRemoveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToRetrieveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\ImpossibleToSaveRole;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleAlreadyExist;
use ProAppointments\IdentityAccess\Domain\Access\Exception\RoleNotFound;
use ProAppointments\IdentityAccess\Domain\Access\Role;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository;
use ProAppointments\IdentityAccess\Domain\Access\RoleRepository as RoleRepositoryPort;
use ProAppointments\IdentityAccess\Infrastructure\Notification\EventStore;
use ProAppointments\IdentityAccess\Infrastructure\Notification\NullEventStore;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\UnknownRepository\UnknownRoleRepository;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class RoleRepositoryAdapter implements RoleRepositoryPort
{
    /** @var RoleRepository */
    private $innerRepository;

    private $eventStore;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(RoleRepository $innerRepository = null, EventStore $eventStore = null, LoggerInterface $logger = null)
    {
        $this->innerRepository = $innerRepository ?: new UnknownRoleRepository();
        $this->eventStore = $eventStore ?: new NullEventStore();
        $this->logger = $logger ?: new NullLogger();
    }

    public function nextIdentity(): RoleId
    {
        return RoleId::generate();
    }

    /**
     * @throws RoleAlreadyExist
     * @throws ImpossibleToSaveRole
     */
    public function add(Role $role): void
    {
        if ($this->roleExist($role->id())) {
            throw  RoleAlreadyExist::withId($role->id());
        }
        try {
            $this->innerRepository->add($role);
            $this->appendEventToEventStore($role);
        } catch (Exception $e) {
            throw new ImpossibleToSaveRole('Persistence error, impossible to save role: '.$role->name()->toString());
        }
    }

    /**
     * @throws RoleNotFound
     * @throws ImpossibleToRetrieveRole
     */
    public function ofId(RoleId $roleId): Role
    {
        if (!$this->roleExist($roleId)) {
            throw  RoleNotFound::withId($roleId);
        }
        try {
            $user = $this->innerRepository->ofId($roleId);
        } catch (Exception $e) {
            throw new ImpossibleToRetrieveRole('Persistence error, impossible to retrieve role with id: '.$roleId->toString());
        }

        return $user;
    }

    /**
     * @throws RoleNotFound
     * @throws ImpossibleToSaveRole
     */
    public function update(Role $role): void
    {
        if (!$this->roleExist($role->id())) {
            throw  RoleNotFound::withId($role->id());
        }
        try {
            $this->innerRepository->update($role);
            $this->appendEventToEventStore($role);
        } catch (Exception $e) {
            throw new ImpossibleToSaveRole('Persistence error, impossible to save role: '.$role->name()->toString());
        }
    }

    /**
     * @throws ImpossibleToRemoveRole
     */
    public function remove(Role $role): void
    {
        try {
            $this->appendEventToEventStore($role);
            $this->innerRepository->remove($role);
        } catch (\Exception $exception) {
            throw new ImpossibleToRemoveRole('Persistence error, impossible to remove role: '.$role->name()->toString());
        }
    }

    private function appendEventToEventStore(Role $role): void
    {
        $events = $role->releaseEvents();

        foreach ($events as $event) {
            $this->eventStore->append($event);
        }
    }

    private function roleExist(RoleId $roleId): bool
    {
        return $this->innerRepository->roleExist($roleId);
    }
}
