<?php

namespace App\Repository;

use App\Entity\OfferStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class OfferStatusRepository extends ServiceEntityRepository
{
    /**
     * OfferStatusRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OfferStatus::class);
    }
}
