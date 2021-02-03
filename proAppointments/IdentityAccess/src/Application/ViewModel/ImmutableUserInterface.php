<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\ViewModel;

interface ImmutableUserInterface
{
    public function id(): string;

    public function email(): string;

    public function firstName();

    public function lastName();

    public function contactEmail(): string;

    public function contactNumber();
}
