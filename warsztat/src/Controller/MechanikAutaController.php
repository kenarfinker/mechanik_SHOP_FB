<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MechanikAutaController extends AbstractController
{
    private const STATUS_PRZYJETE_ID = 1; // u Ciebie: 1 = "przyjęte"

    #[Route('/mechanik/auta', name: 'mechanik_auta', methods: ['GET'])]
    public function auta(Connection $conn): Response
    {
        if (!$this->isGranted('ROLE_MECHANIK') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $auta = $conn->fetchAllAssociative("
            SELECT
                s.id,
                s.marka,
                s.model,
                s.rok_produkcji,
                s.numer_rejestracyjny,
                s.vin,
                u.imie AS wlasciciel_imie,
                u.nazwisko AS wlasciciel_nazwisko
            FROM samochody s
            JOIN uzytkownicy u ON u.id = s.uzytkownik_id
            ORDER BY s.id DESC
        ");

        return $this->render('mechanik/auta.html.twig', [
            'auta' => $auta,
        ]);
    }

    #[Route('/mechanik/auta/{samochodId}/zlecenie/nowe', name: 'mechanik_zlecenie_nowe', methods: ['GET', 'POST'])]
    public function noweZlecenie(int $samochodId, Request $request, Connection $conn): Response
    {
        if (!$this->isGranted('ROLE_MECHANIK') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $samochod = $conn->fetchAssociative(
            "SELECT s.*, u.imie AS wlasciciel_imie, u.nazwisko AS wlasciciel_nazwisko
             FROM samochody s
             JOIN uzytkownicy u ON u.id = s.uzytkownik_id
             WHERE s.id = ?",
            [$samochodId]
        );
        if (!$samochod) {
            throw $this->createNotFoundException();
        }

        $uslugi = $conn->fetchAllAssociative("SELECT id, nazwa, cena FROM uslugi ORDER BY nazwa ASC");

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('zlecenie_new_'.$samochodId, (string)$request->request->get('_token'))) {
                throw $this->createAccessDeniedException();
            }

            $userId = $this->getUser()->getId();
            $mechanikId = $conn->fetchOne('SELECT id FROM mechanicy WHERE uzytkownik_id = ?', [$userId]);

            if (!$mechanikId) {
                throw $this->createAccessDeniedException('Brak przypisanego mechanika do tego konta.');
            }

            $uslugaId = (int)$request->request->get('usluga_id');
            $opis = trim((string)$request->request->get('opis'));

            $usluga = $conn->fetchAssociative('SELECT id, cena FROM uslugi WHERE id = ?', [$uslugaId]);
            if (!$usluga) {
                $this->addFlash('error', 'Wybrana usługa nie istnieje.');
                return $this->redirectToRoute('mechanik_zlecenie_nowe', ['samochodId' => $samochodId]);
            }

            $conn->beginTransaction();
            try {
                $conn->executeStatement(
                    'INSERT INTO zlecenia (samochod_id, mechanik_id, opis, status_id) VALUES (?, ?, ?, ?)',
                    [$samochodId, $mechanikId, ($opis === '' ? null : $opis), self::STATUS_PRZYJETE_ID]
                );

                $zlecenieId = (int)$conn->lastInsertId();

            $conn->executeStatement(
                'INSERT INTO zlecenia_uslugi (zlecenie_id, usluga_id, ilosc, cena) VALUES (?, ?, 1, ?)',
                [$zlecenieId, $uslugaId, $usluga['cena']]
            );

                $conn->commit();
            } catch (\Throwable $e) {
                $conn->rollBack();
                throw $e;
            }

            return $this->redirectToRoute('moje_zlecenia');
        }

        return $this->render('mechanik/auto_nowe_zlecenie.html.twig', [
            'samochod' => $samochod,
            'uslugi' => $uslugi,
        ]);
    }
}
