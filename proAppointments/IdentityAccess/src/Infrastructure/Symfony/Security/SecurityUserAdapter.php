<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Security;

use ProAppointments\IdentityAccess\Domain\Identity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityUserAdapter implements UserInterface
{
    /** @var User */
    private $user;

    /**
     * SecurityUserAdapter constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword(): string
    {
        return $this->user->password()->toString();
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt(): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername(): string
    {
        return $this->user->email()->toString();
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }
}