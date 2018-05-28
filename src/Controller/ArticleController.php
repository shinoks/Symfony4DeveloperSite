<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;

class ArticleController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Article::class)->findBy([],[
            $request->query->get('sort','id')=>$request->query->get('direction','asc')
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query);

        return $this->render('front/articles.html.twig',array(
            'pagination'=> $pagination
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function show(int $id, Request $request)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Komentarz został́ dodany');
        }
        return $this->render('front/article_show.html.twig',array(
            'article'=> $article
        ));
    }

    /**
     * @param int $categoryId
     * @return Response
     */
    public function showByCategory(int $categoryId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Article::class)->findBy(['category' => $categoryId],[
            $request->query->get('sort','id')=>$request->query->get('direction','desc')
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );


        return $this->render('front/articles.html.twig',array(
            'pagination'=> $pagination
        ));
    }
}
