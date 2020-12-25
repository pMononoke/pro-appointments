<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Domain\Identity\Exception;

use ProAppointments\IdentityAccess\Domain\Identity\UserId;

class ImpossibleToSaveUser extends UserException
{
    private $id;

    public function __construct(UserId $id, string $message = '', int $code = 0, \Exception $previous = null)
    {
        $this->id = $id;
        parent::__construct($message, $code, $previous);
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public static function withId(UserId $id, int $code = 0, \Exception $previous = null): self
    {
        return new self($id, \sprintf('Can not save user %s persistence layer error.', $id), $code, $previous);
    }
}
