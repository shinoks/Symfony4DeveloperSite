<?php

namespace App\Repository;

use App\Entity\ZipCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ZipCodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ZipCode::class);
    }


    public function findByCode($value)
    {
        return $this->createQueryBuilder('z')
            ->where('z.code = :value')
            ->setParameter('value', $value)
            ->orderBy('z.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

}
