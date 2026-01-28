<?php

namespace App\Repository;

use App\Entity\Samochod;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SamochodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Samochod::class);
    }

    public function findByUzytkownik(User $user): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.uzytkownik = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
