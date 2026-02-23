<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'zlecenia')]
class Zlecenie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Samochod::class)]
    #[ORM\JoinColumn(name: 'samochod_id', referencedColumnName: 'id', nullable: false)]
    private ?Samochod $samochod = null;

    #[ORM\ManyToOne(targetEntity: Mechanik::class)]
    #[ORM\JoinColumn(name: 'mechanik_id', referencedColumnName: 'id', nullable: false)]
    private ?Mechanik $mechanik = null;

    #[ORM\Column(type: 'text')]
    private string $opis;

    #[ORM\Column(name: 'data_przyjecia', type: 'datetime')]
    private \DateTimeInterface $dataPrzyjecia;

    #[ORM\Column(name: 'data_zakonczenia', type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dataZakonczenia = null;

    #[ORM\ManyToOne(targetEntity: StatusZlecenia::class)]
    #[ORM\JoinColumn(name: 'status_id', referencedColumnName: 'id', nullable: false)]
    private ?StatusZlecenia $status = null;

    // ================= GETTERY =================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSamochod(): ?Samochod
    {
        return $this->samochod;
    }

    public function getMechanik(): ?Mechanik
    {
        return $this->mechanik;
    }

    public function getOpis(): string
    {
        return $this->opis;
    }

    public function getDataPrzyjecia(): \DateTimeInterface
    {
        return $this->dataPrzyjecia;
    }

    public function getDataZakonczenia(): ?\DateTimeInterface
    {
        return $this->dataZakonczenia;
    }

    public function getStatus(): ?StatusZlecenia
    {
        return $this->status;
    }
}