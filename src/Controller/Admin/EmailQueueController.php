<?php
namespace App\Controller\Admin;

use App\Entity\EmailQueue;
use App\Utils\MailManagerUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\EmailQueueType;

class EmailQueueController extends Controller
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request){

        $emailQueue = new EmailQueue();
        $form = $this->createForm(EmailQueueType::class, $emailQueue);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($emailQueue);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'EmailQueue został zapisany');

            return $this->redirectToRoute('admin_emailsqueue');
        }

        return $this->render('back/email_queue_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $emailQueue = $this->getDoctrine()
            ->getRepository(EmailQueue::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($emailQueue);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Email został usunięty');

        return $this->redirectToRoute('admin_emails_queue');
    }

    /**
     * @return Response
     */
    public function emailsQueue(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(EmailQueue::class)->findBy([],[
            $request->query->get('sort','id')=>$request->query->get('direction','asc')
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );

        return $this->render('back/emails_queue.html.twig',array(
            'pagination'=> $pagination
        ));
    }

    public function sendEmails(\Swift_Mailer $mailer,EntityManagerInterface $emi)
    {
        $emails = $this->getDoctrine()
            ->getRepository(EmailQueue::class)
            ->findBy(['send' => 0],['id' => 'asc'],5);
        $emailAddresses = 0;
        if($emails){
            $mailManager = new MailManagerUtils($emi);
            foreach($emails as $email){
                $mailBody = $email->getNewsletter()->getText();
                $template = $this->renderView('emails/newsletter_base.html.twig',array(
                    'mailBody'=> $mailBody
                ));
                $parameters['subject'] = $email->getNewsletter()->getTitle();
                $to = $email->getEmail();

                if($mailManager->sendEmail($template, $parameters, $to, $mailer)){
                    $email->setSend(1);
                    $email->setSendDate(new \DateTime('now'));

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($email);
                    $em->flush();
                }

                $emailAddresses = $emailAddresses +1;
            }
        }

        return new JsonResponse($emailAddresses);
    }
}
