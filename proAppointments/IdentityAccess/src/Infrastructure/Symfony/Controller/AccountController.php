<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Controller;

use ProAppointments\IdentityAccess\Application\UserViewCase\MyAccountRequest;
use ProAppointments\IdentityAccess\Application\UserViewCase\MyAccountVewCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /** @var MyAccountVewCase */
    private $service;

    /**
     * AccountController constructor.
     */
    public function __construct(MyAccountVewCase $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/account", name="account")
     */
    public function index(): Response
    {
        $request = new MyAccountRequest($this->getUser()->getId());

        $userViewData = $this->service->execute($request);

        return $this->render('@identity/account/index.html.twig', [
            'userViewData' => $userViewData,
        ]);
    }
}
