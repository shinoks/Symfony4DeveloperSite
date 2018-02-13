<?php
namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    public function users()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('back/users.html.twig',array(
            'users'=> $users
        ));
    }

    /**
     * @return Response
     */
    public function edit($id, Request $request, UserPasswordEncoderInterface $passwordEncoder)    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        if($user){
            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Użytkownik został zmieniony');

                return $this->render('back/user_edit.html.twig',array(
                    'admin'=> $user,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/user_edit.html.twig',array(
                'user'=> $user,
                'form'=> $form->createView()
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Użytkownik nie został znaleziony');

            return $this->redirectToRoute('admin_users');
        }
    }

    /**
     * @return Response
     */
    public function new(Request $request,  UserPasswordEncoderInterface $passwordEncoder){

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Użytkownik został dodany');

            return $this->redirectToRoute('admin_admin_edit',array('id'=>$user->getId()));
        }

        return $this->render('back/user_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @return Response
     */
    public function disable($id, $status)    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $user->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Użytkownik został wyłączony');

        return $this->redirectToRoute('admin_users');
    }

    /**
     * @return Response
     */
    public function delete($id)    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Uzytkownik został usunięty');

        return $this->redirectToRoute('admin_users');
    }
}
