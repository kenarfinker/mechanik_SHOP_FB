<?php

namespace App\Controller;

use App\Entity\Usluga;
use App\Repository\UslugaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MechanikUslugiController extends AbstractController
{
    #[Route('/mechanik/katalog', name: 'mechanik_katalog', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        UslugaRepository $uslugaRepo,
        EntityManagerInterface $em
    ): Response {
        $this->denyUnlessMechanikOrAdmin();

        // Dodawanie usługi
        if ($request->isMethod('POST')) {
            $this->validateCsrfToken('usluga_add', $request->request->get('_token'));

            $nazwa = trim((string) $request->request->get('nazwa'));
            $cena  = trim((string) $request->request->get('cena'));

            if ($nazwa !== '' && $cena !== '') {
                $usluga = (new Usluga())
                    ->setNazwa($nazwa)
                    ->setCena($cena);

                $em->persist($usluga);
                $em->flush();

                return $this->redirectToRoute('mechanik_katalog');
            }

            $this->addFlash('error', 'Uzupełnij nazwę i cenę.');
        }

        return $this->render('mechanik/katalog.html.twig', [
            'uslugi' => $uslugaRepo->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/mechanik/katalog/usluga/{id}/usun', name: 'mechanik_usluga_usun', methods: ['POST'])]
    public function usun(
        int $id,
        Request $request,
        UslugaRepository $uslugaRepo,
        EntityManagerInterface $em
    ): Response {
        $this->denyUnlessMechanikOrAdmin();

        $this->validateCsrfToken('usluga_del_' . $id, $request->request->get('_token'));

        $usluga = $uslugaRepo->find($id);
        if ($usluga) {
            $em->remove($usluga);
            $em->flush();
        }

        return $this->redirectToRoute('mechanik_katalog');
    }

    private function denyUnlessMechanikOrAdmin(): void
    {
        if (!$this->isGranted('ROLE_MECHANIK') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }
    }

    private function validateCsrfToken(string $id, ?string $token): void
    {
        if (!$this->isCsrfTokenValid($id, (string) $token)) {
            throw $this->createAccessDeniedException('Błędny token CSRF.');
        }
    }
}
