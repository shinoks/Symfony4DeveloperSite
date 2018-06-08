<?php

namespace App\Repository;

use App\Entity\Subscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SubscriberRepository extends ServiceEntityRepository
{
    /**
     * SubscriberRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subscriber::class);
    }

    public function count(array $criteria = null)
    {
        return $this->createQueryBuilder('z')
            ->select('count(z.id)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
