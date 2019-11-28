<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter;

use ProAppointments\IdentityAccess\Domain\User\Exception\ImpossibleToRemoveUser;
use ProAppointments\IdentityAccess\Domain\User\Exception\ImpossibleToSaveUser;
use ProAppointments\IdentityAccess\Domain\User\Exception\UserAlreadyExist;
use ProAppointments\IdentityAccess\Domain\User\Exception\UserNotFound;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserRepository;
use ProAppointments\IdentityAccess\Infrastructure\Notification\EventStore;
use ProAppointments\IdentityAccess\Infrastructure\Notification\NullEventStore;

class UserRepositoryAdapter implements UserRepository
{
//    /** @var UserRepository */
    private $repository;

    private $eventStore;

    /**
     * UserRepositoryAdapter constructor.
     *
     * @param EventStore $eventStore
     */
    public function __construct(object $repository, ?EventStore $eventStore = null)
    {
        $this->repository = $repository;
        $this->eventStore = $eventStore ? $eventStore : new NullEventStore();
    }

    /**
     * @throws UserAlreadyExist
     * @throws ImpossibleToSaveUser
     */
    public function register(User $user): void
    {
        if ($this->repository->ofId($user->id())) {
            throw  UserAlreadyExist::withId($user->id());
        }

        try {
            $this->repository->register($user);
            $this->appendEventToEventStore($user);
        } catch (\Exception $exception) {
            throw ImpossibleToSaveUser::withId($user->id());
        }
    }

    /**
     * @throws UserNotFound
     */
    public function ofId(UserId $userId): User
    {
        if (null === $user = $this->repository->ofId($userId)) {
            throw  UserNotFound::withId($userId);
        }

        return $user;
    }

    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }

    public function remove(User $user): void
    {
        try {
            $this->appendEventToEventStore($user);
            $this->repository->remove($user);
        } catch (\Exception $exception) {
            throw ImpossibleToRemoveUser::withId($user->id());
        }
    }

    /**
     * @throws ImpossibleToSaveUser
     */
    public function save(User $user): void
    {
        try {
            $this->repository->save($user);
            $this->appendEventToEventStore($user);
        } catch (\Exception $exception) {
            throw ImpossibleToSaveUser::withId($user->id());
        }
    }

    private function appendEventToEventStore(User $user): void
    {
        $events = $user->releaseEvents();

        foreach ($events as $event) {
            $this->eventStore->append($event);
        }
    }
}
