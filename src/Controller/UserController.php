<?php
namespace App\Controller;

use App\Entity\Recruitment;
use App\Entity\RecruitmentUsers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Config;
use App\Form\UserType;

class UserController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('roles');
        $form->remove('isActive');
        $form->remove('isEnabledByAdmin');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(array('ROLE_USER'));
            $user->setIsActive(0);
            $user->setIsEnabledByAdmin(0);
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setHash(uniqid("",true));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->session = new Session();
            $this->session->getFlashBag()->add('success', 'Zostałeś zarejestrowany. Potwierdź rejestrację klikając w link w przesłanej wiadomości email');

            $config = $this->getDoctrine()
                ->getRepository(Config::class)
                ->find(1);

            $message = (new \Swift_Message('Formularz rejestracyjny z '.$config->getTitle()))
                ->setFrom($config->getEmail())
                ->setReplyTo($config->getEmail())
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/register_form.html.twig',
                        ['user' => $user, 'config' => $config]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);

            return $this->redirectToRoute('login');
        }

        return $this->render('front/register.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param string $h
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function enable(string $h)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['hash' => $h]);
        if($user){
            $user->setIsActive(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Użytkownik został aktywowany. Możesz się zalogować');
        }

        return $this->redirectToRoute('login');
    }

    /**
     * @return Response
     */
    public function account()
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser());

        $recruitmentUserOffers = $this->getDoctrine()
            ->getRepository(RecruitmentUsers::class)
            ->getRecruitmentUsersOfferByUser($user);

        $recruitments = $this->getDoctrine()
            ->getRepository(Recruitment::class)
            ->findAllByActive(1);

        return $this->render('front/account.html.twig',array(
            'recruitments' => $recruitments,
            'recruitmentUserOffers' => $recruitmentUserOffers
        ));
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser());
        if($user){
            $form = $this->createForm(UserType::class, $user);
            $form->remove('roles');
            $form->remove('isActive');
            $form->remove('isEnabledByAdmin');
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Użytkownik został zmieniony');

                return $this->render('front/account_user_edit.html.twig',array(
                    'user'=> $user,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('front/account_user_edit.html.twig',array(
                'user'=> $user,
                'form'=> $form->createView()
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Użytkownik nie został znaleziony');

            return $this->redirectToRoute('front_user_account');
        }
    }
}
