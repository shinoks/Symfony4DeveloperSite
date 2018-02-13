<?php
namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Admin;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Form\AdminType;
use App\Form\UserType;

class DefaultController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function index(AuthorizationCheckerInterface $authChecker)
    {
        if (false === $authChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Unable to access this page!');
        }
        return $this->render('back/start.html.twig',array());
    }

}
