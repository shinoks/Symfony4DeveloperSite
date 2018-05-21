<?php

namespace App\Repository;

use App\Entity\ModulePosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ModulePositionRepository extends ServiceEntityRepository
{
    /**
     * ModulePositionRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModulePosition::class);
    }
}
