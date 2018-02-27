<?php

namespace App\Repository;

use App\Entity\Realization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RealizationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Realization::class);
    }


    public function findLatestRealizations($value)
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult()
        ;
    }
}
