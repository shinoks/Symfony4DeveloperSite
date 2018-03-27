<?php
namespace App\Controller;

use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Comment;

class CommentController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @param $event
     * @param $eventId
     * @return null|array
     */
    public function showEventComments($event, $eventId): ?array
    {
        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(['event'=>$event,'eventId'=>$eventId]);

        return $comments;
    }

    /**
     * @param Request $request
     * @param $route
     * @return bool
     */
    public function add(Request $request, $route)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Komentarz został́ dodany');
        }
        return true;
    }

}
