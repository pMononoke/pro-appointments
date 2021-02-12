<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Application\ViewModel;

interface ImmutableUserInterface
{
    public function id(): string;

    public function email(): string;

    /**
     * @return string|null
     */
    public function firstName();

    /**
     * @return string|null
     */
    public function lastName();

    public function contactEmail(): string;

    /**
     * @return string|null
     */
    public function contactNumber();
}
