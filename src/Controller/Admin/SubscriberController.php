<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Subscriber;
use App\Form\SubscriberType;

class SubscriberController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * SubscriberController constructor.
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
        $article = $this->getDoctrine()
            ->getRepository(Subscriber::class)
            ->find($id);

        return $this->render('back/subscriber_show.html.twig',array(
            'article'=> $article
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($subscriber);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Uzytkownik został dodany do newslettera');

            return $this->redirectToRoute('admin_subscriber_edit',array('id'=>$subscriber->getId()));
        }

        return $this->render('back/subscriber_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $article = $this->getDoctrine()
            ->getRepository(Subscriber::class)
            ->find($id);
        $article->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        if($status == 1){
            $this->session->getFlashBag()->add('success', 'Użytkownik został włączony do powiadamiania newsletterem');
        }else {
            $this->session->getFlashBag()->add('success', 'Użytkownik został wyłączony z powiadamiania newsletterem');
        }

        return $this->redirectToRoute('admin_subscribers');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $subscriber = $this->getDoctrine()
            ->getRepository(Subscriber::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($subscriber);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Użytkownik został usunięty z newslettera');

        return $this->redirectToRoute('admin_subscribers');
    }

    /**
     * @return Response
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Subscriber::class)->findBy([],[
            $request->query->get('sort','id')=>$request->query->get('direction','asc')
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );


        return $this->render('back/subscribers.html.twig',array(
            'pagination'=> $pagination
        ));
    }
}
