<?php
namespace App\Controller;

use App\Entity\Recruitment;
use App\Entity\RecruitmentUsers;
use App\Form\PasswordNewType;
use App\Form\PasswordResetType;
use App\Form\UserUpdateType;
use App\Utils\MailManagerUtils;
use App\Utils\RecaptchaUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Config;
use App\Form\UserType;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

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
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, RecaptchaUtils $recaptchaUtils, EntityManagerInterface $emi)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $captcha = $recaptchaUtils->check($request->get('g-recaptcha-response'),$request->getClientIp());
            if($captcha == false){
                $this->session->getFlashBag()->add('danger', 'Wypełnij formularz ponownie. Błąd captchy');

                return $this->render('front/register.html.twig',array(
                    'form' => $form->createView()
                ));
            }
            $user->setRoles(array('ROLE_USER'));
            $user->setIsActive(0);
            $user->setIsEnabledByAdmin(0);
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setHash(uniqid("", true));
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
            $mailManager = new MailManagerUtils($emi);
            $mailer->send($message);
            $mailBody = $this->renderView('emails/user_new_created.html.twig');
            $mailManager->sendEmail($mailBody,['subject' => 'Nowy użytkownik się zarejestrował - '.$config->getTitle()],$config->getEmail(),$mailer);

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
            $user->setHash(null);

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
            ->findRecruitmentsForUsers();

        return $this->render('front/account.html.twig',array(
            'user' => $user,
            'recruitments' => $recruitments,
            'recruitmentUserOffers' => $recruitmentUserOffers
        ));
    }

    /**
     * @return Response
     */
    public function resetPassword(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(PasswordResetType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            try{
                $userFound = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findOneBy((['email' => $user['email'], 'birthDate' => $user['birthDate']]));
            }catch(UsernameNotFoundException $exception)
            {
                $this->session->getFlashBag()->add('success', 'Link do zmiany hasła został wysłany');
            }
            if($userFound) {
                $userFound->setHash(uniqid("", true));

                $em = $this->getDoctrine()->getManager();
                $em->persist($userFound);
                $em->flush();

                $config = $this->getDoctrine()
                    ->getRepository(Config::class)
                    ->find(1);

                $message = (new \Swift_Message('Formularz zmiany hasła z '.$config->getTitle()))
                    ->setFrom($config->getEmail())
                    ->setReplyTo($config->getEmail())
                    ->setTo($userFound->getEmail())
                    ->setBody(
                        $this->renderView(
                            'emails/account_password_reset.html.twig',
                            ['user' => $userFound, 'config' => $config]
                        ),
                        'text/html'
                    )
                ;
                $mailer->send($message);
                $this->session->getFlashBag()->add('success', 'Link do zmiany hasła został wysłany');
            } else {
                $this->session->getFlashBag()->add('danger', 'Podany użytkownik nie został znaleziony');
            }
        }
        return $this->render('front/password_reset.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param string $h
     */
    public function newPassword(string $h, UserPasswordEncoderInterface $passwordEncoder, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneBy(['hash' => $h]);
        if($user){
            $user->setHash($h);
            $form = $this->createForm(PasswordNewType::class, $user);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $user->setHash(NULL);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Hasło zostało zmienione. Zapraszamy do logowania.');

                return $this->redirectToRoute('login');
            }

            return $this->render('front/password_reset.html.twig',array(
                'form'=> $form->createView(),
                'user' => $user
            ));
        }

        return $this->redirectToRoute('login');
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
            $form = $this->createForm(UserUpdateType::class, $user);
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function updateUserData($recruitmentId, Request $request)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser());
        if($user){
            $form = $this->createForm(UserUpdateType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Dane użytkownika zostały uzupełnione');

                return $this->redirectToRoute('front_user_recruitment_user_new',['recruitmentId' => $recruitmentId]);
            }

            return $this->render('front/account_user_update.html.twig',array(
                'user'=> $user,
                'form'=> $form->createView()
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Użytkownik nie został znaleziony');

            return $this->redirectToRoute('front_user_account');
        }
    }
}
