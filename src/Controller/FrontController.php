<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Article;

class FrontController extends Controller
{
    /**
     * @return Response
     */
    public function startPage()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(array(),array('created'=>'DESC'),3);

        return $this->render('front/start.html.twig',array(
            'articles' => $articles
        ));
    }

    /**
     * @return Response
     */
    public function contactPage()
    {
        return $this->render('front/contact.html.twig',array());
    }

    /**
     * @return Response
     */
    public function articleShow($id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        return $this->render('front/article_show.html.twig',array(
            'article'=> $article
        ));
    }
}
