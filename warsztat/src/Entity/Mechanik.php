<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'mechanicy')]
class Mechanik
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'uzytkownik_id', referencedColumnName: 'id', nullable: false)]
    private ?User $uzytkownik = null;

    #[ORM\Column(length: 100)]
    private string $specjalizacja;

    #[ORM\Column(length: 20)]
    private string $telefon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUzytkownik(): ?User
    {
        return $this->uzytkownik;
    }
}