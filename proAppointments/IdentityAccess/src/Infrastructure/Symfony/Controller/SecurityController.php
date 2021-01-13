<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/identity/{vueRouting}", name="identity", defaults={"vueRouting"=null}, requirements={"vueRouting"="^(?!api).+"})
     */
    public function indexAction(): Response
    {
        return $this->render('base.html.twig', []);
    }
}
