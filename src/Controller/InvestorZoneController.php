<?php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class InvestorZoneController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function index()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['category' =>'5']);

        return $this->render('front/investor_zone.html.twig',array(
            'articles'=> $articles
        ));
    }

    /**
     * @return Response
     */
    public function show($id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        return $this->render('front/investor_zone_show.html.twig',array(
            'article'=> $article
        ));
    }
}
