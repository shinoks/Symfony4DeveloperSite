<?php
namespace App\Controller\Admin;

use App\Entity\EmailQueue;
use App\Entity\Newsletter;
use App\Entity\RecruitmentUsers;
use App\Entity\Subscriber;
use App\Entity\User;
use App\Form\NewsletterSendType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\NewsletterType;

class NewsletterController extends Controller
{
    /**
     * @var Session
     */
    private $session;

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
        $newsletter = $this->getDoctrine()
            ->getRepository(Newsletter::class)
            ->find($id);

        return $this->render('back/newsletter_show.html.twig',array(
            'newsletter'=> $newsletter
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)    {
        $newsletter = $this->getDoctrine()
            ->getRepository(Newsletter::class)
            ->find($id);

        if($newsletter){
            $form = $this->createForm(NewsletterType::class, $newsletter);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $newsletter = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($newsletter);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Newsletter został zmieniony');

                return $this->redirectToRoute('admin_newsletter_edit',['id'=>$id]);
            }

            return $this->render('back/newsletter_edit.html.twig',array(
                'newsletter'=> $newsletter,
                'form'=> $form->createView()
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Newsletter nie został znaleziony');

            return $this->redirectToRoute('admin_newsletters');
        }

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request){

        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Newsletter został zapisany');

            return $this->redirectToRoute('admin_newsletter_edit',array('id'=>$newsletter->getId()));
        }

        return $this->render('back/newsletter_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $newsletter = $this->getDoctrine()
            ->getRepository(Newsletter::class)
            ->find($id);
        $newsletter->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newsletter);
        $em->flush();

        if($status == 1){
            $this->session->getFlashBag()->add('success', 'Newsletter został włączony');
        }else {
            $this->session->getFlashBag()->add('success', 'Newsletter został wyłączony');
        }

        return $this->redirectToRoute('admin_newsletters');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $newsletter = $this->getDoctrine()
            ->getRepository(Newsletter::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($newsletter);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Newsletter został usunięty');

        return $this->redirectToRoute('admin_newsletters');
    }

    /**
     * @return Response
     */
    public function newsletters(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Newsletter::class)->findBy([],[
            $request->query->get('sort','id')=>$request->query->get('direction','asc')
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );

        return $this->render('back/newsletters.html.twig',array(
            'pagination'=> $pagination
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addToQueue(Request $request){

        $form = $this->createForm(NewsletterSendType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $newsletter = $this->getDoctrine()
                ->getRepository(Newsletter::class)
                ->find($data['newsletter']);
            if($newsletter){
                $em = $this->getDoctrine()->getManager();
                switch($data['newsletterUsers']){
                    case 'recruitment':
                        if($data['recruitment']){
                            $users = $this->getDoctrine()
                                ->getRepository(RecruitmentUsers::class)
                                ->distinctUserFromRecruitment($data['recruitment'])
                            ;
                            foreach($users as $user){
                                $emailQueue = new EmailQueue();
                                $us = $this->getDoctrine()
                                    ->getRepository(User::class)
                                    ->find($user[1]);
                                $emailQueue->setName($us->getFirstName() . ' ' . $us->getFirstName());
                                $emailQueue->setEmail($us->getEmail());
                                $emailQueue->setNewsletter($newsletter);
                                $em->persist($emailQueue);
                            }
                        }

                        break;
                    case 'all_users':
                        $users = $this->getDoctrine()
                            ->getRepository(User::class)
                            ->findAllActive();

                        foreach($users as $user){
                            $emailQueue = new EmailQueue();
                            $emailQueue->setName($user[0]->getFirstName() . ' ' . $user[0]->getFirstName());
                            $emailQueue->setEmail($user[0]->getEmail());
                            $emailQueue->setNewsletter($newsletter);
                            $em->persist($emailQueue);
                        }

                        break;
                    case 'newsletter_users':
                        $users = $this->getDoctrine()
                            ->getRepository(Subscriber::class)
                            ->findAll();

                        foreach($users as $user){
                            $emailQueue = new EmailQueue();
                            $emailQueue->setName($user->getName());
                            $emailQueue->setEmail($user->getEmail());
                            $emailQueue->setNewsletter($newsletter);
                            $em->persist($emailQueue);
                        }

                        break;
                }

                $em->flush();

                $this->session->getFlashBag()->add('success', 'Wysyłka emaili została dodana, ilość emaili: ' . count($users));
            }

            return $this->redirectToRoute('admin_emails_queue');
        }

        return $this->render('back/newsletter_add_to_queue.html.twig',array(
            'form'=> $form->createView()
        ));
    }
}
