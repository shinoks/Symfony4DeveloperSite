<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }


    public function findByOnStartPage($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.onStartPage = :value')->setParameter('value', $value)
            ->orderBy('a.created', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
