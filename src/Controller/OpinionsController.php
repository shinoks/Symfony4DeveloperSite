<?php
namespace App\Controller;

use App\Entity\Opinions;
use App\Form\CommentType;
use App\Form\OpinionsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Comment;

class OpinionsController extends Controller
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
     * @param int $limit
     * @return Response
     */
    public function getLatestOpinions(int $limit = 10, $route)
    {
        $opinions = new Opinions();
        $form = $this->createForm(OpinionsType::class, $opinions,[
            'action' => $this->generateUrl('front_opinions',['route' => $route]),
        ]);

        $latestOpinions = $this->getDoctrine()
            ->getRepository(Opinions::class)
            ->findBy(['isActive' => 1],['id' => 'desc'],$limit);

        return $this->render('front/addons/opinions.html.twig',[
            'form' => $form->createView(),
            'route' => $route,
            'latestOpinions' => $latestOpinions
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add($route,Request $request)
    {
        $opinions = new Opinions();
        $form = $this->createForm(OpinionsType::class, $opinions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $opinions->setIsActive(0);
            if($this->getUser()){
                $opinions->setUser($this->getUser());
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($opinions);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Opinia została dodana czeka na aktywację');

        }

        return $this->redirectToRoute($route);
    }

}
