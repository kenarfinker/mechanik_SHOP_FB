<?php

namespace App\Controller;

use App\Entity\Usluga;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OfertaController extends AbstractController
{
    #[Route('/oferta', name: 'oferta')]
    public function index(EntityManagerInterface $em): Response
    {
        $uslugi = $em->getRepository(Usluga::class)
            ->findBy([], ['nazwa' => 'ASC']);

        return $this->render('oferta/index.html.twig', [
            'uslugi' => $uslugi
        ]);
    }
}