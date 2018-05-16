<?php

namespace App\Repository;

use App\Entity\Recruitment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RecruitmentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Recruitment::class);
    }


    public function getRecruitmentWithCount()
    {
        return $this->createQueryBuilder('r')
            ->select('r,SUM(recruitmentUsers.payedAmount) as payedSum,SUM(recruitmentUsers.declaredAmount) as declaredSum')
            ->leftJoin('r.recruitmentUsers','recruitmentUsers')
            ->groupBy('r.id')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
