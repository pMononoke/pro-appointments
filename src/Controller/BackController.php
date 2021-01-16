<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * @Route("/administration/{vueRouting}", name="administration", defaults={"vueRouting"=null}, requirements={"vueRouting"="^(?!api).+"})
     */
    public function indexAction(): Response
    {
        return $this->render('vue.base.html.twig', []);
    }
}
