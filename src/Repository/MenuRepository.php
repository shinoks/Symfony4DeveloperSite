<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MenuRepository extends ServiceEntityRepository
{
    /**
     * MenuRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function findOneByActiveUrl(string $value)
    {
        return $this->createQueryBuilder('m')
            ->where('m.href LIKE :value')->setParameter('value', $value)
            ->andWhere('m.parent is NULL')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function findOneByActiveUrlAndInMain(string $value)
    {
        return $this->createQueryBuilder('m')
            ->where('m.href LIKE :value')->setParameter('value', $value)
            ->where('m.inMain LIKE :value')->setParameter('value', 1)
            ->andWhere('m.parent is NULL')
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
