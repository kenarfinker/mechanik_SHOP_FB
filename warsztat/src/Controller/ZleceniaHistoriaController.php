<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ZleceniaHistoriaController extends AbstractController
{
    private const ZAKONCZONE_ID = 3; // <- PODMIEŃ na ID statusu "zakończone" z bazy

    #[Route('/mechanik/zlecenia/historia', name: 'historia_zlecen', methods: ['GET'])]
    public function index(Connection $conn): Response
    {
        if (!$this->isGranted('ROLE_MECHANIK') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $sql = "
            SELECT
                z.id,
                z.opis,
                z.data_przyjecia,
                z.data_zakonczenia,
                sz.nazwa AS status,
                s.marka,
                s.model,
                s.numer_rejestracyjny,
                uk.imie  AS klient_imie,
                uk.nazwisko AS klient_nazwisko,
                um.imie  AS mechanik_imie,
                um.nazwisko AS mechanik_nazwisko,
                z.mechanik_id,
                z.status_id
            FROM zlecenia z
            JOIN samochody s ON s.id = z.samochod_id
            JOIN uzytkownicy uk ON uk.id = s.uzytkownik_id
            JOIN statusy_zlecen sz ON sz.id = z.status_id
            LEFT JOIN mechanicy m ON m.id = z.mechanik_id
            LEFT JOIN uzytkownicy um ON um.id = m.uzytkownik_id
            ORDER BY z.id DESC
        ";

        $zlecenia = $conn->fetchAllAssociative($sql);

        return $this->render('mechanik/historia_zlecen.html.twig', [
            'zlecenia' => $zlecenia,
        ]);
    }

    #[Route('/mechanik/zlecenia/moje', name: 'moje_zlecenia', methods: ['GET'])]
    public function mojeZlecenia(Connection $conn): Response
    {
        if (!$this->isGranted('ROLE_MECHANIK') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            $sql = "
                SELECT z.id, z.opis, z.data_przyjecia, z.data_zakonczenia, sz.nazwa AS status
                FROM zlecenia z
                JOIN statusy_zlecen sz ON sz.id = z.status_id
                ORDER BY z.id DESC
            ";
            $zlecenia = $conn->fetchAllAssociative($sql);
        } else {
            $userId = $this->getUser()->getId();

            $mechanikId = $conn->fetchOne(
                'SELECT id FROM mechanicy WHERE uzytkownik_id = ?',
                [$userId]
            );

            if (!$mechanikId) {
                $zlecenia = [];
            } else {
                $sql = "
                    SELECT z.id, z.opis, z.data_przyjecia, z.data_zakonczenia, sz.nazwa AS status
                    FROM zlecenia z
                    JOIN statusy_zlecen sz ON sz.id = z.status_id
                    WHERE z.mechanik_id = ?
                    ORDER BY z.id DESC
                ";
                $zlecenia = $conn->fetchAllAssociative($sql, [$mechanikId]);
            }
        }

        return $this->render('mechanik/moje_zlecenia.html.twig', [
            'zlecenia' => $zlecenia,
        ]);
    }

    #[Route('/mechanik/zlecenia/{id}/edytuj', name: 'zlecenie_edytuj', methods: ['GET', 'POST'])]
    public function edytuj(int $id, Request $request, Connection $conn): Response
    {
        if (!$this->isGranted('ROLE_MECHANIK') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $zlecenie = $conn->fetchAssociative('SELECT * FROM zlecenia WHERE id = ?', [$id]);
        if (!$zlecenie) {
            throw $this->createNotFoundException();
        }

        if (!$this->isGranted('ROLE_ADMIN')) {
            $userId = $this->getUser()->getId();

            $mechanikId = $conn->fetchOne(
                'SELECT id FROM mechanicy WHERE uzytkownik_id = ?',
                [$userId]
            );

            if (!$mechanikId || (int)$zlecenie['mechanik_id'] !== (int)$mechanikId) {
                throw $this->createAccessDeniedException();
            }
        }

        $statusy = $conn->fetchAllAssociative('SELECT id, nazwa FROM statusy_zlecen ORDER BY id');

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('zlecenie_edit_'.$id, (string)$request->request->get('_token'))) {
                throw $this->createAccessDeniedException();
            }

            $opis = trim((string)$request->request->get('opis'));
            $statusId = (int)$request->request->get('status_id');
            $dataZak = trim((string)$request->request->get('data_zakonczenia'));

            $statusExists = (int)$conn->fetchOne('SELECT COUNT(*) FROM statusy_zlecen WHERE id = ?', [$statusId]);
            if ($statusExists === 0) {
                return $this->redirectToRoute('zlecenie_edytuj', ['id' => $id]);
            }

            if ($statusId === self::ZAKONCZONE_ID && $dataZak === '') {
                $dataZak = (new \DateTimeImmutable())->format('Y-m-d');
            }

            $dataZakParam = ($dataZak === '') ? null : $dataZak;

            $conn->executeStatement(
                'UPDATE zlecenia SET opis = ?, status_id = ?, data_zakonczenia = ? WHERE id = ?',
                [$opis, $statusId, $dataZakParam, $id]
            );

            return $this->redirectToRoute('moje_zlecenia');
        }

        return $this->render('mechanik/zlecenie_edytuj.html.twig', [
            'zlecenie' => $zlecenie,
            'statusy' => $statusy,
            'zakonczone_id' => self::ZAKONCZONE_ID,
        ]);
    }
}
