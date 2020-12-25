<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Application\Port\In;

interface ChangeNotesUseCase
{
    public function ChangeNotes(ChangeNotesCommand $command);
}
