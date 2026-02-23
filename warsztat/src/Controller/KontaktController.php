<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class KontaktController extends AbstractController
{
    #[Route('/kontakt', name: 'kontakt')]
    public function index(): Response
    {
        return $this->render('kontakt/index.html.twig');
    }
}