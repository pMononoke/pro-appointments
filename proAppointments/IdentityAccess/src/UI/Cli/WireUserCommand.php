<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\UI\Cli;

use ProAppointments\IdentityAccess\Application\UserUseCase\RegisterUserRequest;
use ProAppointments\IdentityAccess\Application\UserUseCase\RegisterUserService;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WireUserCommand extends Command
{
    /** @var RegisterUserService */
    private $registerUserService;

    public function __construct(RegisterUserService $registerUserService)
    {
        parent::__construct('wire:user');
        $this->registerUserService = $registerUserService;
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //TODO Temp. code
        $request = new RegisterUserRequest(
            UserId::generate(),
            UserEmail::fromString('example@example.com'),
            UserPassword::fromString('default'),
            FirstName::fromString('default name'),
            LastName::fromString('default last name'),
            MobileNumber::fromString('+39-392-9999999')
        );

        $this->registerUserService->execute($request);

        return 0;
    }
}
