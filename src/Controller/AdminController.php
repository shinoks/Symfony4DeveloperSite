<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticleType;

class AdminController extends Controller
{
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

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
$info = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $info = 'ok';
        }

        return $this->render('back/article_edit.html.twig',array(
            'article'=> $article,
            'form'=> $form->createView(),
            'info' => $info
        ));
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
