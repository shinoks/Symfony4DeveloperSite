<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Article;

class FrontController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }
    /**
     * @return Response
     */
    public function startPage()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(array(),array('created'=>'DESC'),3);

        return $this->render('front/start.html.twig',array(
            'articles' => $articles,
            'session' => $this->session
        ));
    }

    /**
     * @return Response
     */
    public function contactPage()
    {
        return $this->render('front/contact.html.twig',array(
            'session' => $this->session
        ));
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

    /**
     * @return Response
     */
    public function userRegister(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('roles');
        $form->remove('isActive');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(array('ROLE_USER'));
            $user->setIsActive(1);
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->session = new Session();
            $this->session->getFlashBag()->add('success', 'Użytkownik został utworzony');

            return $this->redirectToRoute('login');
        }

        return $this->render('front/register.html.twig',array(
            'form' => $form->createView(),
            'session' => $this->session
        ));
    }
}
