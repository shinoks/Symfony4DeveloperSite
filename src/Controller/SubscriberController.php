<?php
namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\CommentType;
use App\Form\SubscriberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Comment;
use App\Entity\Config;

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
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subscribe(Request $request, \Swift_Mailer $mailer)
    {
        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subscriber->setHash(uniqid('', true));
            $subscriber->setIsActive(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscriber);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Potwierdź zapisanie do newslettera klikając w link przesłany mailem');

            $config = $this->getDoctrine()
                ->getRepository(Config::class)
                ->find(1);

            $message = (new \Swift_Message('Potwierdzenie zapisu do newslettera : '.$config->getTitle()))
                ->setFrom($config->getEmail())
                ->setReplyTo($config->getEmail())
                ->setTo($subscriber->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/subscriber_form.html.twig',
                        ['subscriber' => $subscriber, 'config' => $config]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
        }

        return $this->render('front/subscriber.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @param string $h
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function enable(string $h)
    {
        $subscriber = $this->getDoctrine()
            ->getRepository(Subscriber::class)
            ->findOneBy(['hash' => $h]);
        if($subscriber){
            $subscriber->setIsActive(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($subscriber);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Adres email został aktywowany.');
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSubscribeForm()
    {
        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberType::class, $subscriber,[
            'action' => $this->generateUrl('front_subscriber'),
        ]);

        return $this->render('front/addons/subscriber.html.twig',[
            'form' => $form->createView()
        ]);
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
