<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Access\Exception;

use ProAppointments\IdentityAccess\Domain\Access\RoleId;

final class RoleAlreadyExist extends RoleException
{
    private $id;

    public function __construct(RoleId $id, string $message = '', int $code = 0, \Exception $previous = null)
    {
        $this->id = $id;
        parent::__construct($message, $code, $previous);
    }

    public function id(): RoleId
    {
        return $this->id;
    }

    public static function withId(RoleId $id, int $code = 0, \Exception $previous = null): self
    {
        return new self($id, \sprintf('Role %s already exist.', $id), $code, $previous);
    }
}
