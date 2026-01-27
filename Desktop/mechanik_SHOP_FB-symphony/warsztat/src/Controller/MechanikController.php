<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MechanikController extends AbstractController
{
     #[Route('/mechanik/katalog', name: 'mechanik_katalog')]
    public function katalog(): Response
    {
        return $this->render('mechanik/katalog.html.twig');
    }

    #[Route('/mechanik', name: 'mechanik_panel')]
public function panel(): Response
{
    return $this->render('mechanik/index.html.twig');
}
}




