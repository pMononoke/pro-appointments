<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User\Exception;

final class InvalidUserException extends UserException implements UserExceptionInterface
{
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
