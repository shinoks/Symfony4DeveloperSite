<?php
namespace App\Controller\Admin;

use App\Entity\Social;
use App\Form\SocialType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;;

class SocialController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * SocialController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function index()
    {
        $socials = $this->getDoctrine()
            ->getRepository(Social::class)
            ->findAll();

        return $this->render('back/socials.html.twig',array(
            'socials'=> $socials
        ));
    }

    public function new(Request $request){

        $social = new Social();
        $form = $this->createForm(SocialType::class, $social);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($social);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Ikona medii został zmieniony');

            return $this->redirectToRoute('admin_social_edit',array('id'=>$social->getId()));
        }

        return $this->render('back/social_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }
    /**
     * @return Response
     */
    public function edit(Request $request)    {
        $social = $this->getDoctrine()
            ->getRepository(Social::class)
            ->find(1);
        if($social){
            $form = $this->createForm(SocialType::class, $social);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $social = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($social);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Ikona medii została zmieniona');

                return $this->render('back/social_edit.html.twig',array(
                    'social'=> $social,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/social_edit.html.twig',array(
                'social'=> $social,
                'form'=> $form->createView()
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Ikona medii nie została znaleziona');

            return $this->redirectToRoute('admin_social');
        }
    }
    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $social = $this->getDoctrine()
            ->getRepository(Social::class)
            ->find($id);
        $social->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($social);
        $em->flush();

        if($status == 1){
            $this->session->getFlashBag()->add('success', 'Ikona została włączona');
        }else {
            $this->session->getFlashBag()->add('success', 'Ikona została wyłączona');
        }

        return $this->redirectToRoute('admin_socials');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $social = $this->getDoctrine()
            ->getRepository(Social::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($social);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Ikona została usunięta');

        return $this->redirectToRoute('admin_socials');
    }
}
