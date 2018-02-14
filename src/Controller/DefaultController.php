<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Article;

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
            ->findBy(array(),array('created'=>'DESC'),3);

        return $this->render('front/start.html.twig',array(
            'articles' => $articles,
            'session' => $this->session
        ));
    }

    /**
     * @return Response
     */
    public function contactPage()
    {
        return $this->render('front/contact.html.twig',array(
            'session' => $this->session
        ));
    }
}
