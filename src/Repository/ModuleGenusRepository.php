<?php

namespace App\Repository;

use App\Entity\ModuleGenus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ModuleGenusRepository extends ServiceEntityRepository
{
    /**
     * ModuleGenusRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ModuleGenus::class);
    }
}
