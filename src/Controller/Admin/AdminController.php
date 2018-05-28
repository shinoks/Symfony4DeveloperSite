<?php
namespace App\Controller\Admin;

use App\Entity\Admin;
use Doctrine\DBAL\DBALException;
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
    /**
     * @var Session
     */
    private $session;

    /**
     * AdminController constructor.
     */
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
    public function admins(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Admin::class)->findBy([],[
            $request->query->get('sort','id')=>$request->query->get('direction','asc')
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );


        return $this->render('back/admins.html.twig',array(
            'pagination'=> $pagination,
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request, UserPasswordEncoderInterface $passwordEncoder)    {
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
                try{
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($admin);
                    $em->flush();
                }catch (DBALException $e) {
                    $message = $e->getMessage();
                    $mess = explode(':',$message);
                    $this->session->getFlashBag()->add('danger', 'Admin nie został usunięty'.$mess[1].' --- '. $message);

                    return $this->redirectToRoute('admin_admin_edit',['id' => $id]);
                }

                $this->session->getFlashBag()->add('success', 'Admin został zmieniony');

                return $this->render('back/admin_edit.html.twig',array(
                    'admin'=> $admin,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/admin_edit.html.twig',array(
                'admin'=> $admin,
                'form'=> $form->createView()
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Admin nie został znaleziony');

            return $this->redirectToRoute('admin_admins');
        }
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($admin, $admin->getPassword());
            $admin->setPassword($password);
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($admin);
                $em->flush();
            }catch (DBALException $e) {
                $message = $e->getMessage();
                $mess = explode(':',$message);
                $this->session->getFlashBag()->add('danger', 'Admin nie został zmieniony'.$mess[1].' --- '. $message);

                return $this->redirectToRoute('admin_admin_new');
            }

            $this->session->getFlashBag()->add('success', 'Admin został dodany');

            return $this->redirectToRoute('admin_admin_edit',array('id'=>$admin->getId()));
        }

        return $this->render('back/admin_edit.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);
        $admin->setIsActive($status);
        try{
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();
        }catch (DBALException $e) {
            $message = $e->getMessage();
            $mess = explode(':',$message);
            $this->session->getFlashBag()->add('danger', 'Admin nie wyłączony'.$mess[1].' --- '. $message);

        return $this->redirectToRoute('admin_admins');
        }

        $this->session->getFlashBag()->add('success', 'Admin został wyłączony');

        return $this->redirectToRoute('admin_admins');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($admin);
            $em->flush();
        }catch (DBALException $e) {
            $message = $e->getMessage();
            $mess = explode(':',$message);
            $this->session->getFlashBag()->add('danger', 'Admin nie został usunięty'.$mess[1].' --- '. $message);

        return $this->redirectToRoute('admin_admins');
        }

        $this->session->getFlashBag()->add('success', 'Admin został usunięty');

        return $this->redirectToRoute('admin_admins');
    }

}
