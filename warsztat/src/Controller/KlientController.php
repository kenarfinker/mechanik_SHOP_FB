<?php

namespace App\Controller;

use App\Repository\SamochodRepository;
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

    #[Route('/klient/samochody', name: 'klient_samochody')]
    public function samochody(SamochodRepository $repo): Response
    {
        $user = $this->getUser();

        $samochody = $repo->findByUzytkownik($user);

        return $this->render('klient/samochody.html.twig', [
            'samochody' => $samochody
        ]);
    }
}
