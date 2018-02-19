<?php
namespace App\Controller\Admin;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\ArticleType;
use App\Service\FileUploader;

class ArticleController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function show($id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        return $this->render('back/article_show.html.twig',array(
            'article'=> $article
        ));
    }

    /**
     * @return Response
     */
    public function edit($id, Request $request)    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        $imageOld = $article->getImage();
        if($article){
            $form = $this->createForm(ArticleType::class, $article);

            $article->setImage(new File($imageOld));
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $article = $form->getData();
                if(!$article->getImage()){
                    $article->setImage(new File($imageOld));
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
     * @return Response
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
     * @return Response
     */
    public function disable($id, $status)    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);
        $article->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Artykuł został wyłączony');

        return $this->redirectToRoute('admin_articles');
    }

    /**
     * @return Response
     */
    public function delete($id)    {
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
    public function articles()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('back/articles.html.twig',array(
            'articles'=> $articles
        ));
    }
}
