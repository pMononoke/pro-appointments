<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/web{vueRouting}", name="front_index", defaults={"vueRouting"=null}, requirements={"vueRouting"="^(?!api).+"})
     */
    public function indexAction(): Response
    {
        return $this->render('vue.base.html.twig', []);
    }
}
