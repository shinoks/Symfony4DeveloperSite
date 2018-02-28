<?php
namespace App\Controller\Admin;

use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\AdminType;

class AdminController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function index(AuthorizationCheckerInterface $authChecker)
    {
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Unable to access this page!');
        }
        return $this->render('back/start.html.twig',array());
    }


    /**
     * @return Response
     */
    public function admins()
    {
        $admins = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findAll();

        return $this->render('back/admins.html.twig',array(
            'admins'=> $admins,
        ));
    }

    /**
     * @return Response
     */
    public function edit($id, Request $request, UserPasswordEncoderInterface $passwordEncoder)    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);
        if($admin){
            $form = $this->createForm(AdminType::class, $admin);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $admin = $form->getData();
                $password = $passwordEncoder->encodePassword($admin, $admin->getPassword());
                $admin->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($admin);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Admin został zmieniony');

                return $this->render('back/admin_edit.html.twig',array(
                    'admin'=> $admin,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/admin_edit.html.twig',array(
                'admin'=> $admin,
                'form'=> $form->createView(),
                'session'=>$this->session
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Admin nie został znaleziony');

            return $this->redirectToRoute('admin_admins');
        }
    }

    /**
     * @return Response
     */
    public function new(Request $request,  UserPasswordEncoderInterface $passwordEncoder){

        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($admin, $admin->getPassword());
            $admin->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Admin został dodany');

            return $this->redirectToRoute('admin_admin_edit',array('id'=>$admin->getId()));
        }

        return $this->render('back/admin_edit.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @return Response
     */
    public function disable($id, $status)    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);
        $admin->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Admin został wyłączony');

        return $this->redirectToRoute('admin_admins');
    }

    /**
     * @return Response
     */
    public function delete($id)    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($admin);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Admin został usunięty');

        return $this->redirectToRoute('admin_admins');
    }

}
