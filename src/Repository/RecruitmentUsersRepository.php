<?php

namespace App\Repository;

use App\Entity\RecruitmentUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RecruitmentUsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RecruitmentUsers::class);
    }

    public function getRecruitmentUsersOfferByUser($user)
    {
        return $this->createQueryBuilder('r')
            ->where('r.user = :user')->setParameter('user', $user)
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getRecruitmentUsersOfferByUserAndRecruitment($user,$recruitmentId)
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.recruitment','recruitment')
            ->where('r.user = :user')->setParameter('user', $user)
            ->andWhere('recruitment.id = :recruitmentId')->setParameter('recruitmentId', $recruitmentId)
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getRecruitmentUsersDeclaredAmountSumByRecruitmentAndIsActive($recruitmentId)
    {
        return $this->createQueryBuilder('r')
            ->select('sum(r.declaredAmount) as declaredAmount,recruitment.id')
            ->leftJoin('r.recruitment','recruitment')
            ->where('r.isActive = :is_active')->setParameter('is_active', $isActive)
            ->andWhere('recruitment.id = :recruitmentId')->setParameter('recruitmentId', $recruitmentId)
            ->orderBy('recruitment.id', 'DESC')
            ->groupBy('recruitment.id')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getRecruitmentUsersDeclaredAmountSumByIsActive($isActive)
    {
        return $this->createQueryBuilder('r')
            ->select('sum(r.declaredAmount) as declaredAmount,sum(r.payedAmount) as payedAmount,recruitment.id')
            ->leftJoin('r.recruitment','recruitment')
            ->where('r.isActive = :is_active')->setParameter('is_active', $isActive)
            ->orderBy('recruitment.id', 'DESC')
            ->groupBy('recruitment.id')
            ->getQuery()
            ->getResult()
            ;
    }
    public function getRecruitmentSumDeclaredAndPayed($rId)
    {
        return $this->createQueryBuilder('r')
            ->select('sum(r.declaredAmount) as declaredAmount,sum(r.payedAmount) as payedAmount,recruitment.id')
            ->leftJoin('r.recruitment','recruitment')
            ->where('recruitment = :id')->setParameter('id', $rId)
            ->orderBy('recruitment.id', 'DESC')
            ->groupBy('recruitment.id')
            ->getQuery()
            ->getResult()
            ;
    }

    public function count(array $criteria = null)
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function sumDeclaredAmount()
    {
        return $this->createQueryBuilder('z')
            ->select('sum(z.declaredAmount)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function sumPayedAmount()
    {
        return $this->createQueryBuilder('z')
            ->select('sum(z.payedAmount)')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function distinctUserFromRecruitment($recruitmentId)
    {
        return $this->createQueryBuilder('z')
            ->select('DISTINCT(z.user)')
            ->where('z.recruitment = :id')->setParameter('id',$recruitmentId)
            ->getQuery()
            ->getResult()
            ;
    }
}
