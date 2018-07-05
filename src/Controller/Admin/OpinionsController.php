<?php
namespace App\Controller\Admin;

use App\Entity\Opinions;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\OpinionsType;

class OpinionsController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * OpinionsController constructor.
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
        $opinion = $this->getDoctrine()
            ->getRepository(Opinions::class)
            ->find($id);

        return $this->render('back/opinions_show.html.twig',array(
            'opinion'=> $opinion
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)    {
        $opinions = $this->getDoctrine()
            ->getRepository(Opinions::class)
            ->find($id);
        if($opinions){
            $form = $this->createForm(OpinionsType::class, $opinions);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $opinions = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($opinions);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Opinia została zmieniona');

                return $this->render('back/opinions_edit.html.twig',[
                    'opinions'=> $opinions,
                    'form'=> $form->createView()
                ]);
            }

            return $this->render('back/opinions_edit.html.twig',[
                'opinions'=> $opinions,
                'form'=> $form->createView()
            ]);
        }else {

            $this->session->getFlashBag()->add('danger', 'Opinia nie została znaleziona');

            return $this->redirectToRoute('admin_opinions');
        }
    }

    
    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $opinion = $this->getDoctrine()
            ->getRepository(Opinions::class)
            ->find($id);
        $opinion->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($opinion);
        $em->flush();

        if($status == 1){
            $this->session->getFlashBag()->add('success', 'Opinia została wyłączona');
        }else {
            $this->session->getFlashBag()->add('success', 'Opinia została włączona');
        }

        return $this->redirectToRoute('admin_opinions');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $opinion = $this->getDoctrine()
            ->getRepository(Opinions::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($opinion);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Opinia została usunięta');

        return $this->redirectToRoute('admin_opinions');
    }

    /**
     * @return Response
     */
    public function opinions(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Opinions::class)->findBy([],[
            $request->query->get('sort','id')=>$request->query->get('direction','desc')
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );

        return $this->render('back/opinions.html.twig',array(
            'pagination'=> $pagination
        ));
    }
}
