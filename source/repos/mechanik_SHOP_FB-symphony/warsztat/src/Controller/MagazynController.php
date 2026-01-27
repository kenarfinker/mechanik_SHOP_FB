<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MagazynController extends AbstractController
{
    #[Route('/magazyn', name: 'magazyn', methods: ['GET', 'POST'])]
    public function index(Request $request, Connection $conn): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MECHANIK')) {
            throw $this->createAccessDeniedException();
        }

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('magazyn_add', (string)$request->request->get('_token'))) {
                throw $this->createAccessDeniedException();
            }

            $nazwa = trim((string)$request->request->get('nazwa'));
            $ilosc = (int)$request->request->get('ilosc');
            $ean = trim((string)$request->request->get('kod_ean'));
            $kod = trim((string)$request->request->get('kod_magazynowy'));

            if ($nazwa === '' || $kod === '') {
                return $this->redirectToRoute('magazyn');
            }

            if ($ilosc < 0) $ilosc = 0;

            $conn->executeStatement(
                'INSERT INTO magazyn (nazwa, ilosc, kod_ean, kod_magazynowy) VALUES (?, ?, ?, ?)',
                [$nazwa, $ilosc, ($ean === '' ? null : $ean), $kod]
            );

            return $this->redirectToRoute('magazyn');
        }

        $pozycje = $conn->fetchAllAssociative(
            'SELECT * FROM magazyn ORDER BY nazwa ASC'
        );

        return $this->render('magazyn/index.html.twig', [
            'pozycje' => $pozycje,
        ]);
    }

    #[Route('/magazyn/{id}/edytuj', name: 'magazyn_edytuj', methods: ['GET', 'POST'])]
    public function edytuj(int $id, Request $request, Connection $conn): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MECHANIK')) {
            throw $this->createAccessDeniedException();
        }

        $item = $conn->fetchAssociative('SELECT * FROM magazyn WHERE id = ?', [$id]);
        if (!$item) {
            throw $this->createNotFoundException();
        }

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('magazyn_edit_'.$id, (string)$request->request->get('_token'))) {
                throw $this->createAccessDeniedException();
            }

            $nazwa = trim((string)$request->request->get('nazwa'));
            $ilosc = (int)$request->request->get('ilosc');
            $ean = trim((string)$request->request->get('kod_ean'));
            $kod = trim((string)$request->request->get('kod_magazynowy'));

            if ($ilosc < 0) $ilosc = 0;

            $conn->executeStatement(
                'UPDATE magazyn SET nazwa = ?, ilosc = ?, kod_ean = ?, kod_magazynowy = ? WHERE id = ?',
                [$nazwa, $ilosc, ($ean === '' ? null : $ean), $kod, $id]
            );

            return $this->redirectToRoute('magazyn');
        }

        return $this->render('magazyn/edytuj.html.twig', [
            'item' => $item,
        ]);
    }

    #[Route('/magazyn/{id}/usun', name: 'magazyn_usun', methods: ['POST'])]
    public function usun(int $id, Request $request, Connection $conn): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_MECHANIK')) {
            throw $this->createAccessDeniedException();
        }

        if (!$this->isCsrfTokenValid('magazyn_del_'.$id, (string)$request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $conn->executeStatement('DELETE FROM magazyn WHERE id = ?', [$id]);

        return $this->redirectToRoute('magazyn');
    }
}
