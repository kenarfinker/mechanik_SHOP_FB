<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MechanikController extends AbstractController
{
    #[Route('/mechanik', name: 'mechanik_panel')]
    public function index(): Response
    {
        return $this->render('mechanik/index.html.twig');
    }
}
