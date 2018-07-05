<?php
namespace App\Utils;

use App\Entity\RecruitmentUsers;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class InfoCountUtils
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getNumbers()
    {
        $usersCount = $this->em->getRepository(User::class)->count()+50;
        $recruitmentUsersCount = $this->em->getRepository(RecruitmentUsers::class)->count()+55;
        $recruitmentUsersSum = $this->em->getRepository(RecruitmentUsers::class)->sumDeclaredAmount()+350000;
        $numbers = ['usersCount' => $usersCount, 'recruitmentUsersCount' => $recruitmentUsersCount, 'recruitmentUsersSum' => $recruitmentUsersSum];

        return $numbers;
    }
}
