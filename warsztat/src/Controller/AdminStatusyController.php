<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminStatusyController extends AbstractController
{
    #[Route('/admin/statusy', name: 'admin_statusy', methods: ['GET', 'POST'])]
    public function index(Request $request, Connection $conn): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('status_add', (string) $request->request->get('_token'))) {
                throw $this->createAccessDeniedException();
            }

            $nazwa = trim((string) $request->request->get('nazwa'));

            if ($nazwa === '') {
                $this->addFlash('error', 'Podaj nazwę statusu.');
                return $this->redirectToRoute('admin_statusy');
            }

            $exists = (int) $conn->fetchOne(
                'SELECT COUNT(*) FROM statusy_zlecen WHERE LOWER(TRIM(nazwa)) = LOWER(TRIM(?))',
                [$nazwa]
            );

            if ($exists > 0) {
                $this->addFlash('error', 'Taki status już istnieje.');
                return $this->redirectToRoute('admin_statusy');
            }

            $conn->executeStatement(
                'INSERT INTO statusy_zlecen (nazwa) VALUES (?)',
                [$nazwa]
            );

            $this->addFlash('success', 'Dodano status.');
            return $this->redirectToRoute('admin_statusy');
        }

        $statusy = $conn->fetchAllAssociative('SELECT id, nazwa FROM statusy_zlecen ORDER BY id ASC');

        return $this->render('admin/statusy.html.twig', [
            'statusy' => $statusy,
        ]);
    }
}
