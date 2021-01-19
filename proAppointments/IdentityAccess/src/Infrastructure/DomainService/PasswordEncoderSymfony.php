<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\DomainService;

use InvalidArgumentException;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Domain\Service\PasswordEncoder;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Security\SecurityUserAdapter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderSymfony implements PasswordEncoder
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /**
     * PasswordEncoderSymfony constructor.
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function encode(object $user, string $plainPassword): UserPassword
    {
        if (!$user instanceof User) {
            throw new InvalidArgumentException('Invalid user class, password encoding failure');
        }
        $userAdapter = new SecurityUserAdapter($user);

        $encodedPassword = $this->encoder->encodePassword($userAdapter, $plainPassword);

        return UserPassword::fromString($encodedPassword);
    }
}
