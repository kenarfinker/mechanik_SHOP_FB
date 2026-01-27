<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'samochody')]
class Samochod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'uzytkownik_id', referencedColumnName: 'id', nullable: false)]
    private ?User $uzytkownik = null;

    #[ORM\Column(length: 50)]
    private string $marka;

    #[ORM\Column(length: 50)]
    private string $model;

    #[ORM\Column(type: 'integer')]
    private int $rokProdukcji;

    #[ORM\Column(length: 20)]
    private string $numerRejestracyjny;

    #[ORM\Column(length: 50)]
    private string $vin;

    // ===== GETTERY =====

    public function getId(): ?int { return $this->id; }
    public function getUzytkownik(): ?User { return $this->uzytkownik; }
    public function getMarka(): string { return $this->marka; }
    public function getModel(): string { return $this->model; }
    public function getRokProdukcji(): int { return $this->rokProdukcji; }
    public function getNumerRejestracyjny(): string { return $this->numerRejestracyjny; }
    public function getVin(): string { return $this->vin; }
}
