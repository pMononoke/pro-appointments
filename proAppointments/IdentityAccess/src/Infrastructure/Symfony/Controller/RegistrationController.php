<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Controller;

use CompostDDD\ApplicationService\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /** @var ApplicationService */
    private $usecase;

    /**
     * RegistrationController constructor.
     */
    public function __construct(ApplicationService $registerUserUseCase)
    {
        $this->usecase = $registerUserUseCase;
    }

    /**
     * @Route("/registration", methods={"GET","POST"}, name="identity_register")
     */
    public function registerAction(): Response
    {
        return $this->render('registration/register.html.twig', []);
    }
}
