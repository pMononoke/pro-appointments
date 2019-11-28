<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Access\Exception;

class RoleException extends \RuntimeException implements \ProAppointments\IdentityAccess\Domain\Access\Exception\RoleExceptionInterface
{
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
