<?php
namespace App\Controller\Admin;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\ArticleType;

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
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        return $this->render('back/article_show.html.twig',array(
            'article'=> $article
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);


        $imageOld = $article->getImage();
        if($article){
            $form = $this->createForm(ArticleType::class, $article);
            if($imageOld){
                $article->setImage($imageOld);
            }
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $article = $form->getData();
                if(!$article->getImage()){
                    $article->setImage($imageOld);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Artykuł został zmieniony');

                return $this->redirectToRoute('admin_article_edit',['id'=>$id]);
            }

            return $this->render('back/article_edit.html.twig',array(
                'article'=> $article,
                'form'=> $form->createView()
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Artykuł nie został znaleziony');

            return $this->redirectToRoute('admin_articles');
        }

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request){

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Artykuł został zmieniony');

            return $this->redirectToRoute('admin_article_edit',array('id'=>$article->getId()));
        }

        return $this->render('back/article_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);
        $article->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        if($status == 1){
            $this->session->getFlashBag()->add('success', 'Artykuł został włączony ze strony głównej');
        }else {
            $this->session->getFlashBag()->add('success', 'Artykuł został wyłączony ze strony głównej');
        }

        return $this->redirectToRoute('admin_articles');
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function start(int $id, int $status)    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);
        $article->setStart($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        if($status == 1){
            $this->session->getFlashBag()->add('success', 'Artykuł będzie wyświetlany na stronie głównej');
        }else {
            $this->session->getFlashBag()->add('success', 'Artykuł nie będzie wyświetlany na stronie głównej');
        }

        return $this->redirectToRoute('admin_articles');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Artykuł został usunięty');

        return $this->redirectToRoute('admin_articles');
    }

    /**
     * @return Response
     */
    public function articles(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Article::class)->findBy([],[
            $request->query->get('sort','id')=>$request->query->get('direction','asc')
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );

        return $this->render('back/articles.html.twig',array(
            'pagination'=> $pagination
        ));
    }
}
