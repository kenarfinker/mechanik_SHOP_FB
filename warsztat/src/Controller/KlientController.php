<?php

namespace App\Controller;

use App\Entity\Samochod;
use App\Entity\Zlecenie;
use Doctrine\ORM\EntityManagerInterface;
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
    public function samochody(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $samochody = $em
            ->getRepository(Samochod::class)
            ->findBy(['uzytkownik' => $user]);

        return $this->render('klient/samochody.html.twig', [
            'samochody' => $samochody
        ]);
    }
    #[Route('/klient/zlecenia', name: 'klient_zlecenia')]
    public function zlecenia(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $zlecenia = $em->createQueryBuilder()
            ->select('z', 's')
            ->from(Zlecenie::class, 'z')
            ->join('z.samochod', 's')
            ->where('s.uzytkownik = :user')
            ->setParameter('user', $user)
            ->orderBy('z.dataPrzyjecia', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('klient/zlecenia.html.twig', [
            'zlecenia' => $zlecenia
        ]);
    }
}
