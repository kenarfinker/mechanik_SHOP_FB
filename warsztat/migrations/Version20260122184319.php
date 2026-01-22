<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260122184319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE mechanicy DROP FOREIGN KEY `mechanicy_ibfk_1`');
        $this->addSql('ALTER TABLE samochody DROP FOREIGN KEY `samochody_ibfk_1`');
        $this->addSql('ALTER TABLE uzytkownicy DROP FOREIGN KEY `uzytkownicy_ibfk_1`');
        $this->addSql('ALTER TABLE zlecenia DROP FOREIGN KEY `fk_zlecenia_status`');
        $this->addSql('ALTER TABLE zlecenia DROP FOREIGN KEY `zlecenia_ibfk_1`');
        $this->addSql('ALTER TABLE zlecenia DROP FOREIGN KEY `zlecenia_ibfk_2`');
        $this->addSql('ALTER TABLE zlecenia_uslugi DROP FOREIGN KEY `zlecenia_uslugi_ibfk_1`');
        $this->addSql('ALTER TABLE zlecenia_uslugi DROP FOREIGN KEY `zlecenia_uslugi_ibfk_2`');
        $this->addSql('DROP TABLE mechanicy');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE samochody');
        $this->addSql('DROP TABLE statusy_zlecen');
        $this->addSql('DROP TABLE uslugi');
        $this->addSql('DROP TABLE uzytkownicy');
        $this->addSql('DROP TABLE zlecenia');
        $this->addSql('DROP TABLE zlecenia_uslugi');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mechanicy (id INT AUTO_INCREMENT NOT NULL, uzytkownik_id INT NOT NULL, specjalizacja VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_polish_ci`, telefon VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_polish_ci`, UNIQUE INDEX uzytkownik_id (uzytkownik_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_polish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_polish_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_polish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE samochody (id INT AUTO_INCREMENT NOT NULL, uzytkownik_id INT NOT NULL, marka VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_polish_ci`, model VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_polish_ci`, rok_produkcji INT DEFAULT NULL, numer_rejestracyjny VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_polish_ci`, vin VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_polish_ci`, INDEX uzytkownik_id (uzytkownik_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_polish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE statusy_zlecen (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_polish_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_polish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE uslugi (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_polish_ci`, opis TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_polish_ci`, cena NUMERIC(10, 2) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_polish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE uzytkownicy (id INT AUTO_INCREMENT NOT NULL, imie VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_polish_ci`, nazwisko VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_polish_ci`, email VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_polish_ci`, haslo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_polish_ci`, rola_id INT NOT NULL, data_rejestracji DATETIME DEFAULT \'current_timestamp()\', INDEX rola_id (rola_id), UNIQUE INDEX email (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_polish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE zlecenia (id INT AUTO_INCREMENT NOT NULL, samochod_id INT NOT NULL, mechanik_id INT DEFAULT NULL, opis TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_polish_ci`, data_przyjecia DATETIME DEFAULT \'current_timestamp()\', data_zakonczenia DATETIME DEFAULT \'NULL\', status_id INT NOT NULL, INDEX fk_zlecenia_status (status_id), INDEX samochod_id (samochod_id), INDEX mechanik_id (mechanik_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_polish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE zlecenia_uslugi (id INT AUTO_INCREMENT NOT NULL, zlecenie_id INT NOT NULL, usluga_id INT NOT NULL, ilosc INT DEFAULT 1, cena NUMERIC(10, 2) NOT NULL, INDEX usluga_id (usluga_id), INDEX zlecenie_id (zlecenie_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_polish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mechanicy ADD CONSTRAINT `mechanicy_ibfk_1` FOREIGN KEY (uzytkownik_id) REFERENCES uzytkownicy (id)');
        $this->addSql('ALTER TABLE samochody ADD CONSTRAINT `samochody_ibfk_1` FOREIGN KEY (uzytkownik_id) REFERENCES uzytkownicy (id)');
        $this->addSql('ALTER TABLE uzytkownicy ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (rola_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE zlecenia ADD CONSTRAINT `fk_zlecenia_status` FOREIGN KEY (status_id) REFERENCES statusy_zlecen (id)');
        $this->addSql('ALTER TABLE zlecenia ADD CONSTRAINT `zlecenia_ibfk_1` FOREIGN KEY (samochod_id) REFERENCES samochody (id)');
        $this->addSql('ALTER TABLE zlecenia ADD CONSTRAINT `zlecenia_ibfk_2` FOREIGN KEY (mechanik_id) REFERENCES mechanicy (id)');
        $this->addSql('ALTER TABLE zlecenia_uslugi ADD CONSTRAINT `zlecenia_uslugi_ibfk_1` FOREIGN KEY (zlecenie_id) REFERENCES zlecenia (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zlecenia_uslugi ADD CONSTRAINT `zlecenia_uslugi_ibfk_2` FOREIGN KEY (usluga_id) REFERENCES uslugi (id)');
        $this->addSql('DROP TABLE user');
    }
}
