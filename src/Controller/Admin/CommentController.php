<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Comment;

class CommentController extends Controller
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
        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findAll();

        return $this->render('back/comments.html.twig',array(
            'comments'=> $comments
        ));
    }

    /**
     * @return Response
     */
    public function show($id)
    {
        $comment = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->find($id);

        return $this->render('back/comment_show.html.twig',array(
            'comment'=> $comment
        ));
    }

    /**
     * @return Response
     */
    public function accept($id)
    {
        $comment = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->find($id);
        if($comment->getAccept()==0){
            $comment->setAccept(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Komentarz został zaakceptowany');
        }

        return $this->redirectToRoute('admin_comments');
    }

}
