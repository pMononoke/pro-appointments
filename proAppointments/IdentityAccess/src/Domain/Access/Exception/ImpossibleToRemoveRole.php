<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Access\Exception;

final class ImpossibleToRemoveRole extends RoleException implements RoleExceptionInterface
{
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
