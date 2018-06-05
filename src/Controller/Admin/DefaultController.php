<?php
namespace App\Controller\Admin;

use App\Entity\RecruitmentUsers;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    /**
     * @return Response
     */
    public function index(AuthorizationCheckerInterface $authChecker)
    {
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Unable to access this page!');
        }

        $usersCount = $this->getDoctrine()
            ->getRepository(User::class)
            ->count();

        $recruitmentUsersCount = $this->getDoctrine()
            ->getRepository(RecruitmentUsers::class)
            ->count();

        $recruitmentUsersSumDeclaredAmount = $this->getDoctrine()
            ->getRepository(RecruitmentUsers::class)
            ->sumDeclaredAmount();

        $recruitmentUsersSumPayedAmount = $this->getDoctrine()
            ->getRepository(RecruitmentUsers::class)
            ->sumPayedAmount();

        return $this->render('back/start.html.twig',[
            'usersCount' => $usersCount,
            'recruitmentUsersCount' => $recruitmentUsersCount,
            'recruitmentUsersSumDeclaredAmount' => $recruitmentUsersSumDeclaredAmount,
            'recruitmentUsersSumPayedAmount' => $recruitmentUsersSumPayedAmount,
        ]);
    }

}
