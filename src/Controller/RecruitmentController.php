<?php
namespace App\Controller;

use App\Entity\Recruitment;
use App\Entity\RecruitmentUsers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class RecruitmentUserController
 * @package App\Controller
 */
class RecruitmentController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * OfferController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }


    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $recruitment = $this->getDoctrine()
            ->getRepository(Recruitment::class)
            ->find($id);

        $recruitmentUsers = $this->getDoctrine()
            ->getRepository(RecruitmentUsers::class)
            ->getRecruitmentUsersOfferByUserAndRecruitment($this->getUser(),$id);

        if(empty($recruitment) || $recruitment->getIsActive() == 0){
            throw new NotFoundResourceException('Brak dostępu do wybraneej inwestycji');
        }
        if(count($recruitmentUsers)<1){
            throw new NotFoundResourceException('Nie bierzesz udziału w danej inwestycji');
        }

        return $this->render('front/recruitment_show.html.twig',array(
            'recruitment'=> $recruitment
        ));
    }
}
