<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\ViewModel;

interface IdentifiableInterface
{
    public function getId(): string;
}
