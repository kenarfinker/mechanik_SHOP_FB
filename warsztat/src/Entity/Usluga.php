<?php

namespace App\Entity;

use App\Repository\UslugaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UslugaRepository::class)]
#[ORM\Table(name: 'uslugi')]
class Usluga
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $nazwa = '';

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $cena = '0.00';

    public function getId(): ?int { return $this->id; }

    public function getNazwa(): string { return $this->nazwa; }
    public function setNazwa(string $nazwa): self { $this->nazwa = $nazwa; return $this; }

    public function getCena(): string { return $this->cena; }
    public function setCena(string $cena): self { $this->cena = $cena; return $this; }
}
