<?php
namespace App\Controller;

use App\Entity\Config;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Entity\Contact;
use App\Entity\Realization;

class DefaultController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }
    /**
     * @return Response
     */
    public function startPage()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAllStartPage();

        $latestRealizations = $this->getDoctrine()
            ->getRepository(Realization::class)
            ->findLatestRealizations(7);

        return $this->render('front/start.html.twig',array(
            'articles' => $articles,
            'latestRealizations' => $latestRealizations,
            'session' => $this->session
        ));
    }

    /**
     * @return Response
     */
    public function contactPage(Request $request, \Swift_Mailer $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        if($this->getUser()){
            $form->remove('send');
            $contact->setSend($this->getUser()->getEmail());
            $contact->setSender($this->getUser());
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Wiadomość została wysłana');

            $config = $this->getDoctrine()
                ->getRepository(Config::class)
                ->find(1);

            $message = (new \Swift_Message('Formularz kontaktowy:'.$contact->getTitle()))
                ->setFrom($config->getEmail())
                ->setReplyTo($contact->getSend())
                ->setTo($config->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/contact_form.html.twig',
                        array('contact' => $contact)
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);

            return $this->redirectToRoute('contact');
        }
        return $this->render('front/contact.html.twig',array(
            'session' => $this->session,
            'form' => $form->createView()
        ));
    }
}
