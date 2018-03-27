<?php
namespace App\Controller;

use App\Entity\ZipCode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;

class ZipCodeController extends Controller
{
    /**
     * @var Session
     */
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
        $zipCodes = $this->getDoctrine()
            ->getRepository(ZipCode::class)
            ->findAll();

        return $this->render('front/articles.html.twig',array(
            'zipCodes'=> $zipCodes
        ));
    }

    public function show(int $id,Request $request)
    {
        $article = $this->getDoctrine()
            ->getRepository(ZipCode::class)
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

    public function showByCategory(int $categoryId)
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['category' => $categoryId, 'isActive' => 1],['created' => 'DESC']);

        return $this->render('front/articles.html.twig',array(
            'articles'=> $articles
        ));
    }

    public function getZipCode(string $zipCode): JsonResponse
    {
        $zipCode = $this->getDoctrine()
            ->getRepository(ZipCode::class)
            ->findOneBy(['code' => $zipCode]);

        $jsonData = ['code' => $zipCode->getCode(), 'city' => $zipCode->getCity(), 'state' => $zipCode->getState()];

        return new JsonResponse($jsonData);
    }
}
