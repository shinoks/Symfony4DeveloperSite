<?php
namespace App\Controller;

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
    public function articleShow($id)
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
    public function articleDisable($id, $status)    {
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
    public function articleDelete($id)    {
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
            'articles'=> $articles,
            'session'=>$this->session
        ));
    }

    /**
     * @return Response
     */
    public function categories()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('back/categories.html.twig',array(
            'categories'=> $categories,
            'session'=>$this->session
        ));
    }

    /**
     * @return Response
     */
    public function categoryShow($id)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('back/category_show.html.twig',array(
            'category'=> $category
        ));
    }

    /**
     * @return Response
     */
    public function categoryNew(Request $request){

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Artykuł został zmieniony');

            return $this->redirectToRoute('admin_category_edit',array('id'=>$category->getId()));
        }

        return $this->render('back/category_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @return Response
     */
    public function categoryEdit($id, Request $request)    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        if($category){
            $form = $this->createForm(CategoryType::class, $category);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $category = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Kategoria została zmieniona');

                return $this->render('back/category_edit.html.twig',array(
                    'category'=> $category,
                    'form'=> $form->createView(),
                    'session'=>$this->session
                ));
            }

            return $this->render('back/category_edit.html.twig',array(
                'category'=> $category,
                'form'=> $form->createView()
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Kategoria nie została znaleziona');

            return $this->redirectToRoute('admin_categories');
        }
    }

    /**
     * @return Response
     */
    public function categoryDisable($id, $status)    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        $category->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Katgoria została wyłączona');

        return $this->redirectToRoute('admin_categories');
    }

    /**
     * @return Response
     */
    public function categoryDelete($id)    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Kategoria został usunięty');

        return $this->redirectToRoute('admin_categories');
    }

    /**
     * @return Response
     */
    public function admins()
    {
        $admins = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findAll();

        return $this->render('back/admins.html.twig',array(
            'admins'=> $admins,
            'session'=>$this->session
        ));
    }

    /**
     * @return Response
     */
    public function adminEdit($id, Request $request, UserPasswordEncoderInterface $passwordEncoder)    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);
        if($admin){
            $form = $this->createForm(AdminType::class, $admin);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $admin = $form->getData();
                $password = $passwordEncoder->encodePassword($admin, $admin->getPassword());
                $admin->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($admin);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Admin został zmieniony');

                return $this->render('back/admin_edit.html.twig',array(
                    'admin'=> $admin,
                    'form'=> $form->createView(),
                    'session'=>$this->session
                ));
            }

            return $this->render('back/admin_edit.html.twig',array(
                'admin'=> $admin,
                'form'=> $form->createView(),
                'session'=>$this->session
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Admin nie został znaleziony');

            return $this->redirectToRoute('admin_categories');
        }
    }

    /**
     * @return Response
     */
    public function adminNew(Request $request,  UserPasswordEncoderInterface $passwordEncoder){

        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($admin, $admin->getPassword());
            $admin->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Admin został dodany');

            return $this->redirectToRoute('admin_admin_edit',array('id'=>$admin->getId()));
        }

        return $this->render('back/admin_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @return Response
     */
    public function adminDisable($id, $status)    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);
        $admin->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Admin został wyłączony');

        return $this->redirectToRoute('admin_admins');
    }

    /**
     * @return Response
     */
    public function adminDelete($id)    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($admin);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Admin został usunięty');

        return $this->redirectToRoute('admin_admins');
    }

    /**
     * @return Response
     */
    public function users()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('back/users.html.twig',array(
            'users'=> $users,
            'session'=>$this->session
        ));
    }

    /**
     * @return Response
     */
    public function userEdit($id, Request $request, UserPasswordEncoderInterface $passwordEncoder)    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        if($user){
            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Użytkownik został zmieniony');

                return $this->render('back/user_edit.html.twig',array(
                    'admin'=> $user,
                    'form'=> $form->createView(),
                    'session'=>$this->session
                ));
            }

            return $this->render('back/user_edit.html.twig',array(
                'user'=> $user,
                'form'=> $form->createView(),
                'session'=>$this->session
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Użytkownik nie został znaleziony');

            return $this->redirectToRoute('admin_users');
        }
    }

    /**
     * @return Response
     */
    public function userNew(Request $request,  UserPasswordEncoderInterface $passwordEncoder){

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Użytkownik został dodany');

            return $this->redirectToRoute('admin_admin_edit',array('id'=>$user->getId()));
        }

        return $this->render('back/user_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @return Response
     */
    public function userDisable($id, $status)    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $user->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Użytkownik został wyłączony');

        return $this->redirectToRoute('admin_users');
    }

    /**
     * @return Response
     */
    public function userDelete($id)    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Uzytkownik został usunięty');

        return $this->redirectToRoute('admin_users');
    }
}
