<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\UserType;

class UserController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

     /**
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('roles');
        $form->remove('isActive');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(array('ROLE_USER'));
            $user->setIsActive(1);
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->session = new Session();
            $this->session->getFlashBag()->add('success', 'Zostałeś zarejestrowany');

            return $this->redirectToRoute('login');
        }

        return $this->render('front/register.html.twig',array(
            'form' => $form->createView(),
            'session' => $this->session
        ));
    }

    /**
     * @return Response
     */
    public function account()
    {
        return $this->render('front/account.html.twig',array(
            'session' => $this->session
        ));

    }

    /**
     * @return Response
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder)    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser());
        if($user){
            $form = $this->createForm(UserType::class, $user);
            $form->remove('roles');
            $form->remove('isActive');
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
