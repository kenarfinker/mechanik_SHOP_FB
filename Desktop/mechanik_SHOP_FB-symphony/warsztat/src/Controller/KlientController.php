<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KlientController extends AbstractController
{
    #[Route('/klient', name: 'klient_panel')]
    public function index(): Response
    {
        return $this->render('klient/index.html.twig');
    }
}
