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

    public function findAllStartPage()
    {
        return $this->createQueryBuilder('a')
            ->where('a.start = 1')
            ->orderBy('a.created', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

}
