<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Adapter\In\Web;

use ProAppointments\Schedule\Application\Port\In\RegisterAppointmentCommand;
use ProAppointments\Schedule\Application\Port\In\RegisterAppointmentUseCase;
use ProAppointments\Schedule\Domain\Appointment\AppointmentId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentController extends AbstractController
{
    /** @var RegisterAppointmentUseCase */
    private $registerAppointmentService;

    public function __construct(RegisterAppointmentUseCase $registerAppointmentService)
    {
        $this->registerAppointmentService = $registerAppointmentService;
    }

    public function listAppointment()// : ResponseInterface
    {
    }

    /**
     * @Route("/appointment/new", name="app_appointment_new")
     */
    public function registerAppointment(): Response
    {
        // TODO: Implement registerAppointment() method.
        // Map HTTP request to PHP objects
        // Perform authorization checks
        // Validate input
        // Map input to the input model of the use case
        // Call the use case
        // Map output of the use case back to HTTP
        // Return HTTP response
        $number = random_int(0, 100);

        $command = new RegisterAppointmentCommand(AppointmentId::generate());

        $this->registerAppointmentService->registerAppointment($command);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
