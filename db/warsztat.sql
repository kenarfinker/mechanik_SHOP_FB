-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 28, 2026 at 02:39 AM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warsztat`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mechanicy`
--

CREATE TABLE `mechanicy` (
  `id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `specjalizacja` varchar(100) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `mechanicy`
--

INSERT INTO `mechanicy` (`id`, `uzytkownik_id`, `specjalizacja`, `telefon`) VALUES
(1, 2, 'Silniki i diagnostyka', '600700800'),
(2, 3, 'Zawieszenie i hamulce', '500600700');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `nazwa`) VALUES
(1, 'admin'),
(2, 'mechanik'),
(3, 'klient');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `samochody`
--

CREATE TABLE `samochody` (
  `id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `marka` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `rok_produkcji` int(11) DEFAULT NULL,
  `numer_rejestracyjny` varchar(20) DEFAULT NULL,
  `vin` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `samochody`
--

INSERT INTO `samochody` (`id`, `uzytkownik_id`, `marka`, `model`, `rok_produkcji`, `numer_rejestracyjny`, `vin`) VALUES
(1, 4, 'Volkswagen', 'Golf', 2015, 'KR1234A', 'WVWZZZ1KZFW000001'),
(2, 4, 'Audi', 'A4', 2018, 'KR5678B', 'WAUZZZ8K9JA000002'),
(3, 5, 'Toyota', 'Corolla', 2020, 'WA9999C', 'JTDBR32E72000003'),
(4, 6, 'BMW', 'E90', 2011, 'PO1111A', 'WBAPN71010A000004'),
(5, 6, 'Skoda', 'Octavia', 2019, 'PO2222B', 'TMBJJ7NE9K000005'),
(6, 7, 'Ford', 'Focus', 2016, 'GD3333C', 'WF0AXXWPCAG000006'),
(7, 8, 'Opel', 'Astra', 2014, 'LU4444D', 'W0L0AHL085000007'),
(8, 8, 'Mazda', '6', 2021, 'LU5555E', 'JMZGL123456000008'),
(9, 9, 'Hyundai', 'i30', 2018, 'WA6666F', 'TMAHC81UJG000009'),
(10, 10, 'Mercedes', 'C200', 2017, 'KR7777G', 'WDDGF8AB3EA000010');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `statusy_zlecen`
--

CREATE TABLE `statusy_zlecen` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `statusy_zlecen`
--

INSERT INTO `statusy_zlecen` (`id`, `nazwa`) VALUES
(1, 'przyjęte'),
(2, 'w trakcie'),
(3, 'zakończone');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uslugi`
--

CREATE TABLE `uslugi` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `opis` text DEFAULT NULL,
  `cena` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `uslugi`
--

INSERT INTO `uslugi` (`id`, `nazwa`, `opis`, `cena`) VALUES
(1, 'Wymiana oleju', 'Wymiana oleju + filtra', 150.00),
(2, 'Diagnostyka komputerowa', 'Podłączenie do komputera OBD', 120.00),
(3, 'Wymiana klocków hamulcowych', 'Przód lub tył', 250.00),
(4, 'Wymiana rozrządu', 'Kompleksowa usługa', 900.00),
(5, 'Wymiana akumulatora', 'Demontaż starego i montaż nowego', 100.00),
(6, 'Geometria kół', 'Ustawienie zbieżności', 180.00),
(7, 'Wymiana sprzęgła', 'Komplet sprzęgła', 1200.00),
(8, 'Serwis klimatyzacji', 'Nabicie + odgrzybianie', 200.00),
(9, 'Wymiana amortyzatorów', 'Oś przednia lub tylna', 800.00),
(10, 'Przegląd okresowy', 'Kontrola podstawowych elementów', 150.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `rola_id` int(11) NOT NULL,
  `data_rejestracji` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `imie`, `nazwisko`, `email`, `haslo`, `rola_id`, `data_rejestracji`) VALUES
(1, 'Jan', 'Admin', 'admin@warsztat.pl', '$2y$13$2n8HKchKLckHDfjL5VJosueGsP96lOz0c.BJmVHZv8sgcKouQ.SfK', 1, '2026-01-21 22:25:43'),
(2, 'Adam', 'Kowalski', 'kowalski@warsztat.pl', '$2y$13$rh38Tof/SbxWPUnhSWnLBOPl/l1dVW8sAHZzVsuwa3C5PP1J5wniS', 2, '2026-01-21 22:25:43'),
(3, 'Piotr', 'Nowak', 'nowak@warsztat.pl', '$2y$13$rh38Tof/SbxWPUnhSWnLBOPl/l1dVW8sAHZzVsuwa3C5PP1J5wniS', 2, '2026-01-21 22:25:43'),
(4, 'Tomasz', 'Mazur', 'tomek@gmail.com', '$2y$13$rh38Tof/SbxWPUnhSWnLBOPl/l1dVW8sAHZzVsuwa3C5PP1J5wniS', 3, '2026-01-21 22:25:43'),
(5, 'Anna', 'Kaczmarek', 'anna@gmail.com', '$2y$13$rh38Tof/SbxWPUnhSWnLBOPl/l1dVW8sAHZzVsuwa3C5PP1J5wniS', 3, '2026-01-21 22:25:43'),
(6, 'Michał', 'Zieliński', 'michal@gmail.com', '$2y$13$rh38Tof/SbxWPUnhSWnLBOPl/l1dVW8sAHZzVsuwa3C5PP1J5wniS', 3, '2026-01-21 22:31:42'),
(7, 'Katarzyna', 'Lewandowska', 'kasia@gmail.com', '$2y$13$rh38Tof/SbxWPUnhSWnLBOPl/l1dVW8sAHZzVsuwa3C5PP1J5wniS', 3, '2026-01-21 22:31:42'),
(8, 'Paweł', 'Dąbrowski', 'pawel@gmail.com', '$2y$13$rh38Tof/SbxWPUnhSWnLBOPl/l1dVW8sAHZzVsuwa3C5PP1J5wniS', 3, '2026-01-21 22:31:42'),
(9, 'Monika', 'Kamińska', 'monika@gmail.com', '$2y$13$rh38Tof/SbxWPUnhSWnLBOPl/l1dVW8sAHZzVsuwa3C5PP1J5wniS', 3, '2026-01-21 22:31:42'),
(10, 'Robert', 'Woźniak', 'robert@gmail.com', '$2y$13$rh38Tof/SbxWPUnhSWnLBOPl/l1dVW8sAHZzVsuwa3C5PP1J5wniS', 3, '2026-01-21 22:31:42');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zlecenia`
--

CREATE TABLE `zlecenia` (
  `id` int(11) NOT NULL,
  `samochod_id` int(11) NOT NULL,
  `mechanik_id` int(11) DEFAULT NULL,
  `opis` text DEFAULT NULL,
  `data_przyjecia` datetime DEFAULT current_timestamp(),
  `data_zakonczenia` datetime DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `zlecenia`
--

INSERT INTO `zlecenia` (`id`, `samochod_id`, `mechanik_id`, `opis`, `data_przyjecia`, `data_zakonczenia`, `status_id`) VALUES
(1, 1, 1, 'Wymiana oleju i filtrów', '2026-01-21 22:26:23', NULL, 3),
(2, 2, 2, 'Diagnostyka – świeci check engine', '2026-01-21 22:26:23', NULL, 2),
(3, 3, 1, 'Wymiana klocków hamulcowych', '2026-01-21 22:26:23', NULL, 1),
(4, 4, 2, 'Wymiana sprzęgła', '2026-01-21 22:32:07', NULL, 2),
(5, 5, 1, 'Przegląd okresowy', '2026-01-21 22:32:07', NULL, 3),
(6, 6, 2, 'Wymiana akumulatora', '2026-01-21 22:32:07', NULL, 3),
(7, 7, 1, 'Diagnostyka komputerowa', '2026-01-21 22:32:07', NULL, 3),
(8, 8, 1, 'Serwis klimatyzacji', '2026-01-21 22:32:07', NULL, 2),
(9, 9, 2, 'Geometria kół', '2026-01-21 22:32:07', NULL, 1),
(10, 10, 1, 'Wymiana amortyzatorów', '2026-01-21 22:32:07', NULL, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zlecenia_uslugi`
--

CREATE TABLE `zlecenia_uslugi` (
  `id` int(11) NOT NULL,
  `zlecenie_id` int(11) NOT NULL,
  `usluga_id` int(11) NOT NULL,
  `ilosc` int(11) DEFAULT 1,
  `cena` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `zlecenia_uslugi`
--

INSERT INTO `zlecenia_uslugi` (`id`, `zlecenie_id`, `usluga_id`, `ilosc`, `cena`) VALUES
(1, 1, 1, 1, 150.00),
(2, 1, 2, 1, 120.00),
(3, 2, 2, 1, 120.00),
(4, 3, 3, 1, 250.00),
(5, 4, 7, 1, 1200.00),
(6, 5, 10, 1, 150.00),
(7, 8, 8, 1, 200.00),
(8, 10, 9, 1, 800.00);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `mechanicy`
--
ALTER TABLE `mechanicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `samochody`
--
ALTER TABLE `samochody`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uzytkownik_id` (`uzytkownik_id`);

--
-- Indeksy dla tabeli `statusy_zlecen`
--
ALTER TABLE `statusy_zlecen`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uslugi`
--
ALTER TABLE `uslugi`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rola_id` (`rola_id`);

--
-- Indeksy dla tabeli `zlecenia`
--
ALTER TABLE `zlecenia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `samochod_id` (`samochod_id`),
  ADD KEY `mechanik_id` (`mechanik_id`),
  ADD KEY `fk_zlecenia_status` (`status_id`);

--
-- Indeksy dla tabeli `zlecenia_uslugi`
--
ALTER TABLE `zlecenia_uslugi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zlecenie_id` (`zlecenie_id`),
  ADD KEY `usluga_id` (`usluga_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mechanicy`
--
ALTER TABLE `mechanicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `samochody`
--
ALTER TABLE `samochody`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `statusy_zlecen`
--
ALTER TABLE `statusy_zlecen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `uslugi`
--
ALTER TABLE `uslugi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zlecenia`
--
ALTER TABLE `zlecenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zlecenia_uslugi`
--
ALTER TABLE `zlecenia_uslugi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mechanicy`
--
ALTER TABLE `mechanicy`
  ADD CONSTRAINT `mechanicy_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`);

--
-- Constraints for table `samochody`
--
ALTER TABLE `samochody`
  ADD CONSTRAINT `samochody_ibfk_1` FOREIGN KEY (`uzytkownik_id`) REFERENCES `uzytkownicy` (`id`);

--
-- Constraints for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (`rola_id`) REFERENCES `role` (`id`);

--
-- Constraints for table `zlecenia`
--
ALTER TABLE `zlecenia`
  ADD CONSTRAINT `fk_zlecenia_status` FOREIGN KEY (`status_id`) REFERENCES `statusy_zlecen` (`id`),
  ADD CONSTRAINT `zlecenia_ibfk_1` FOREIGN KEY (`samochod_id`) REFERENCES `samochody` (`id`),
  ADD CONSTRAINT `zlecenia_ibfk_2` FOREIGN KEY (`mechanik_id`) REFERENCES `mechanicy` (`id`);

--
-- Constraints for table `zlecenia_uslugi`
--
ALTER TABLE `zlecenia_uslugi`
  ADD CONSTRAINT `zlecenia_uslugi_ibfk_1` FOREIGN KEY (`zlecenie_id`) REFERENCES `zlecenia` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `zlecenia_uslugi_ibfk_2` FOREIGN KEY (`usluga_id`) REFERENCES `uslugi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
