<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter;

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
     * @param object     $repository
     * @param EventStore $eventStore
     */
    public function __construct(object $repository, ?EventStore $eventStore)
    {
        $this->repository = $repository;
        $this->eventStore = $eventStore ? $eventStore : new NullEventStore();
    }

    /**
     * @param User $user
     *
     * @throws UserAlreadyExist
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
            throw $exception;
        }
    }

    /**
     * @param UserId $userId
     *
     * @return User
     *
     * @throws UserNotFound
     */
    public function ofId(UserId $userId): User
    {
        if (null === $user = $this->repository->ofId($userId)) {
            throw  UserNotFound::withId($userId);
        }

        return $user;
    }

    /**
     * @return UserId
     */
    public function nextIdentity(): UserId
    {
        return UserId::generate();
    }

    /**
     * @param User $user
     */
    public function remove(User $user): void
    {
        //$this->repository->remove($user);
        try {
            $this->appendEventToEventStore($user);
            $this->repository->remove($user);
        } catch (\Exception $exception) {
            throw $exception;
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
