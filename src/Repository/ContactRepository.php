<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContactRepository extends ServiceEntityRepository
{
    /**
     * ContactRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @return mixed
     */
    public function findAllDesc()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.created', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return mixed
     */
    public function CountAllNotReaded()
    {
        return $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->where('c.readed = :value')->setParameter('value', 0)
            ->orderBy('c.created', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
