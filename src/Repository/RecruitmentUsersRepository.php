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
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
