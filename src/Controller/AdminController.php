<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\ArticleType;

class AdminController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function startPage(AuthorizationCheckerInterface $authChecker)
    {
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Unable to access this page!');
        }
        return $this->render('back/start.html.twig',array());
    }

    /**
     * @return Response
     */
    public function users()
    {

        return $this->render('back/users.html.twig',array());
    }

    /**
     * @return Response
     */
    public function articleShow($id)
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('back/article_show.html.twig',array(
            'article'=> $article
        ));
    }

    /**
     * @return Response
     */
    public function articleEdit($id, Request $request)    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);
        if($article){
            $form = $this->createForm(ArticleType::class, $article);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $article = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Artykuł został zmieniony');

                return $this->render('back/article_edit.html.twig',array(
                    'article'=> $article,
                    'form'=> $form->createView(),
                    'session'=>$this->session
                ));
            }

            return $this->render('back/article_edit.html.twig',array(
                'article'=> $article,
                'form'=> $form->createView()
            ));
        }else {
            $session = new Session();

            $session->getFlashBag()->add('danger', 'Artykuł nie został znaleziony');

            return $this->redirectToRoute('admin_articles');
        }

    }

    /**
     * @return Response
     */
    public function articleNew(Request $request){

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
    public function articles()
    {
        $session = new Session();
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('back/articles.html.twig',array(
            'articles'=> $articles,
            'session'=>$session
        ));
    }


}
