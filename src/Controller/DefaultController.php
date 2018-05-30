<?php
namespace App\Controller;

use App\Entity\Config;
use App\Form\ContactType;
use App\Utils\RecaptchaUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Entity\Contact;
use App\Entity\Realization;

class DefaultController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * DefaultController constructor.
     */
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


        return $this->render('front/start.html.twig',array(
            'articles' => $articles
        ));
    }

    /**
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function contactPage(Request $request, \Swift_Mailer $mailer, RecaptchaUtils $recaptchaUtils)
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
            $captcha = $recaptchaUtils->check($request->get('g-recaptcha-response'),$request->getClientIp());
            if($captcha == false){
                $this->session->getFlashBag()->add('danger', 'Wypełnij formularz ponownie. Błąd captchy');

                return $this->render('front/contact.html.twig',array(
                    'form' => $form->createView()
                ));
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Wiadomość została wysłana');

            $config = $this->getDoctrine()
                ->getRepository(Config::class)
                ->find(1);

            $message = (new \Swift_Message('Formularz kontaktowy:'.$contact->getTitle()))
                ->setFrom('info@grupaformat.pl')
                ->setReplyTo($contact->getSend())
                ->setTo($config->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/contact_form.html.twig',
                        array('contact' => $contact)
                    ),
                    'text/html'
                );

            $mailer->send($message);
        }

        return $this->render('front/contact.html.twig',array(
            'form' => $form->createView()
        ));
    }
}
