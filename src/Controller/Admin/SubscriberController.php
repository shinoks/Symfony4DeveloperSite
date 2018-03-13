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
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function show($id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Subscriber::class)
            ->find($id);

        return $this->render('back/subscriber_show.html.twig',array(
            'article'=> $article
        ));
    }


    /**
     * @return Response
     */
    public function new(Request $request){

        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberType::class, $article);

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

    public function disable($id, $status)    {
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
     * @return Response
     */
    public function delete($id)    {
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
    public function index()
    {
        $subscribers = $this->getDoctrine()
            ->getRepository(Subscriber::class)
            ->findAll();

        return $this->render('back/subscribers.html.twig',array(
            'subscribers'=> $subscribers
        ));
    }
}
