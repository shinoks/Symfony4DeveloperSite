<?php
namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\CommentType;
use App\Form\SubscriberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Comment;

class SubscriberController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function subscribe(Request $request)
    {
        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberType::class, $subscriber);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $subscriber->setHash(md5(uniqid('', true)));
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscriber);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Zostałeś zapisany do newslettera');
        }


        return $this->render('front/addons/subscriber.html.twig',array(
            'form'=> $articles
        ));
    }

    /**
     * @param Request $request
     * @param $route
     * @return bool
     */
    public function add(Request $request, $route)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Komentarz został́ dodany');
        }
        return true;
    }

}
