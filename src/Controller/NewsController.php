<?php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class NewsController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * NewsController constructor.
     */
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
            ->findBy(['category' =>'2'],['created' => 'DESC']);

        return $this->render('front/news.html.twig',array(
            'articles'=> $articles
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        return $this->render('front/news_show.html.twig',array(
            'article'=> $article
        ));
    }
}
