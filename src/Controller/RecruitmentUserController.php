<?php
namespace App\Controller;

use App\Entity\Recruitment;
use App\Entity\RecruitmentUsers;
use App\Entity\RecruitmentUserStatus;
use App\Form\RecruitmentUsersType;
use App\Utils\MailManagerUtils;
use App\Utils\TcpdfUtils;
use Doctrine\ORM\EntityManagerInterface;
use ProxyManager\Exception\FileNotWritableException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class RecruitmentUserController
 * @package App\Controller
 */
class RecruitmentUserController extends Controller
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
     * @param $recruitmentId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \ErrorException
     */
    public function new($recruitmentId, Request $request, \Swift_Mailer $mailer, EntityManagerInterface $emi)
    {
        $recruitment = $this->getDoctrine()
            ->getRepository(Recruitment::class)
            ->getRecruitmentWithCountById($recruitmentId);
        $minOfferAmount = 10000;
        $maxOfferAmount = $recruitment[0]->getDesiredAmount() - $recruitment['declaredSum'];

        $recruitmentUsers = new RecruitmentUsers();
        $recruitmentUsers->min = $minOfferAmount;
        $recruitmentUsers->max = $maxOfferAmount;
        $form = $this->createForm(RecruitmentUsersType::class,$recruitmentUsers);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recruitmentUserStatus = $this->getDoctrine()
                ->getRepository(RecruitmentUserStatus::class)
                ->find(1);
            $recruitmentUsers->setUser($this->getUser());
            $recruitmentUsers->setRecruitment($recruitment[0]);
            $recruitmentUsers->setStatus($recruitmentUserStatus);
            $recruitmentUsers->setInterest($recruitment[0]->getInterest());
            $recruitmentUsers->setInvestmentPeriod($recruitment[0]->getInvestmentPeriod());
            if($maxOfferAmount<$recruitmentUsers->getDeclaredAmount()){
                throw new \ErrorException('Zadeklarowana kwota jest większa od pozostałej wolnej kwoty w naborze');
            }

            $mailManager = new MailManagerUtils($emi);
            $mailBody = $this->renderView('emails/recruitment_user_new.html.twig',[
                'recruitment' => $recruitment,
            ]);
            if(!$mailBody){
                throw new FileNotFoundException('emails/recruitment_user_new.html.twig');
            }
            $user = $this->getUser();
            $name = $user->getFirstName() . ' ' .$user->getLastName();
            $mailBodyPersonalized = str_replace('user',$name, $mailBody);
            $mailManager->sendEmail($mailBodyPersonalized,['subject' => 'tytul'],$user->getEmail(),$mailer);

            $em = $this->getDoctrine()->getManager();
            $em->persist($recruitmentUsers);
            $em->flush();
            $this->session->getFlashBag()->add('success', 'Oferta na nabór została dodana');

            return $this->redirectToRoute('front_user_account');
        }

        return $this->render('front/recruitment_user_new.html.twig',array(
            'form'=> $form->createView(),
            'recruitment' => $recruitment
        ));
    }

}
