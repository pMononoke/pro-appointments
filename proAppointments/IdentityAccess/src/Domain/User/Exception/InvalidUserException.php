<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\User\Exception;

class InvalidUserException extends \RuntimeException implements UserException
{
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
