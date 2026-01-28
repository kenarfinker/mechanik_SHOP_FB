<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'role')]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $nazwa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwa(): string
    {
        return $this->nazwa;
    }
}
