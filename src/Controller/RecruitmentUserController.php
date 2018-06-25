<?php
namespace App\Controller;

use App\Entity\Config;
use App\Entity\Recruitment;
use App\Entity\RecruitmentUsers;
use App\Entity\RecruitmentUserStatus;
use App\Form\RecruitmentUsersType;
use App\Utils\MailManagerUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
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
        if($this->getUser()->getPesel() && $this->getUser()->getIdNumber() && $this->getUser()->getBankAccount()){
            $recruitment = $this->getDoctrine()
                ->getRepository(Recruitment::class)
                ->getRecruitmentWithCountById($recruitmentId);
            $recruitment = $recruitment[0];
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
                    throw new \ErrorException('Zadeklarowana kwota jest większa od pozostałej wolnej kwoty w inwestycji');
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
                $config = $this->getDoctrine()
                    ->getRepository(Config::class)
                    ->find(1);

                $mailManager->sendEmail($mailBodyPersonalized,['subject' => 'Oferta pożyczki - '.$config->getTitle()],$user->getEmail(),$mailer);

                $em = $this->getDoctrine()->getManager();
                $em->persist($recruitmentUsers);
                $em->flush();

                if($maxOfferAmount==0){
                    $mailBody = $this->renderView('emails/recruitment_declared_amount_reached.html.twig',[
                        'recruitment' => $recruitment,
                    ]);
                    $mailManager->sendEmail($mailBody,['subject' => 'Kwota inwestycji ' . $recruitment[0]->getNumber() . 'została zebrana - '.$config->getTitle()],$config->getEmail(),$mailer);
                }

                $this->session->getFlashBag()->add('success', 'Oferta na inwestycje została dodana');

                return $this->redirectToRoute('front_user_account');
            }

            return $this->render('front/recruitment_user_new.html.twig',array(
                'form'=> $form->createView(),
                'recruitment' => $recruitment
            ));
        }else{
            $this->session->getFlashBag()->add('success', 'Uzupełnij dane by móc kontynuować składanie oferty.');

            return $this->redirectToRoute('front_user_update',['recruitmentId' => $recruitmentId]);
        }
    }

    public function getAgreement($id)
    {
        $recruitmentUser = $this->getDoctrine()
            ->getRepository(RecruitmentUsers::class)
            ->find($id);
        try{
            $file = $this->file($recruitmentUser->getAbsoluteAgreementPath(),$recruitmentUser->getNumber());
        }catch(FileNotFoundException $exception){
            echo 'Umowa nie znaleziona'. $exception->getMessage();

        }

        return $file;
    }
}
