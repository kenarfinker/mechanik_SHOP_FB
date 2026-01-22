<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'uzytkownicy')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $imie;

    #[ORM\Column(length: 50)]
    private string $nazwisko;

    #[ORM\Column(length: 100, unique: true)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $haslo;

    #[ORM\ManyToOne(targetEntity: Role::class)]
    #[ORM\JoinColumn(name: 'rola_id', referencedColumnName: 'id')]
    private ?Role $rola = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $dataRejestracji;

    // ====== SECURITY ======

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        // Symfony wymaga tablicy ról
        return ['ROLE_' . strtoupper($this->rola->getNazwa())];
    }

    public function getPassword(): string
    {
        return $this->haslo;
    }

    public function eraseCredentials(): void {}

    // ====== GETTERY / SETTERY ======

    public function getId(): ?int { return $this->id; }

    public function getImie(): string { return $this->imie; }
    public function setImie(string $imie): self { $this->imie = $imie; return $this; }

    public function getNazwisko(): string { return $this->nazwisko; }
    public function setNazwisko(string $nazwisko): self { $this->nazwisko = $nazwisko; return $this; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function setHaslo(string $haslo): self { $this->haslo = $haslo; return $this; }

    public function getRola(): ?Role { return $this->rola; }
    public function setRola(?Role $rola): self { $this->rola = $rola; return $this; }
}
