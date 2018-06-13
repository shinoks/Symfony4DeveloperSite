<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function count(array $criteria = null)
    {
        return $this->createQueryBuilder('z')
            ->select('count(z.id)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function sum($field)
    {
        return $this->createQueryBuilder('z')
            ->select('sum(:field)')->setParameter('field' , $field)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findAllActive()
    {
        return $this->createQueryBuilder('z')
            ->select('DISTINCT(z.email),z')
            ->where('z.isActive = :id')->setParameter('id',1)
            ->getQuery()
            ->getResult()
            ;
    }
}
