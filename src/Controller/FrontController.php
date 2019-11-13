<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/{vueRouting}", name="index", defaults={"vueRouting": null}, requirements={"vueRouting"="^(?!api).+"})
     */
    public function indexAction(): Response
    {
        return $this->render('base.html.twig', []);
    }
}
