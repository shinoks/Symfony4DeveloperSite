<?php

namespace App\Repository;

use App\Entity\ZipCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ZipCodeRepository extends ServiceEntityRepository
{
    /**
     * ZipCodeRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ZipCode::class);
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function findByCode(string $value)
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
