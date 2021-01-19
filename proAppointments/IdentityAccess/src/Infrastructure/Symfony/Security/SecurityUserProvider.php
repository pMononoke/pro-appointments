<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Security;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class SecurityUserProvider implements UserProviderInterface
{
    /** @var UserLoaderInterface */
    private $userRepository;

    /**
     * SecurityUserProvider constructor.
     */
    public function __construct(UserLoaderInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username): UserInterface
    {
        return $this->userRepository->loadUserByUsername($username);
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof SecurityUserAdapter) {
            throw new UnsupportedUserException(\sprintf('Invalid user class %s', \get_class($user)));
        }

        $securityUserAdapter = $this->userRepository->loadUserByUsername($user->getUsername());
        if (!$securityUserAdapter) {
            throw new UsernameNotFoundException(\sprintf('No user found for "%s"', $user->getUsername()));
        }

        return $securityUserAdapter;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class): bool
    {
        return SecurityUserAdapter::class === $class;
    }
}
