<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\UI\Cli;

use ProAppointments\IdentityAccess\Application\UserUseCase\DeleteUserRequest;
use ProAppointments\IdentityAccess\Application\UserUseCase\DeleteUserService;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WireDeleteUserCommand extends Command
{
    /** @var DeleteUserService */
    private $deleteUserService;

    public function __construct(DeleteUserService $deleteUserService)
    {
        parent::__construct('wire:user:delete');
        $this->deleteUserService = $deleteUserService;
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //TODO Temp. code
        $request = new DeleteUserRequest(
            //UserId::generate()
            UserId::fromString('e7087dc7-e87a-4331-ab28-89b0f4656590')
        );

        $this->deleteUserService->execute($request);

        return 0;
    }
}
