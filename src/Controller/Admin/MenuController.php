<?php
namespace App\Controller\Admin;

use App\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\MenuType;

class MenuController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * MenuController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $menu = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->find($id);

        return $this->render('back/menu_show.html.twig',array(
            'menu'=> $menu
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)    {
        $menu = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->find($id);

        if($menu){
            $form = $this->createForm(MenuType::class, $menu);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $menu = $form->getData();
                $menu->setHref($this->generateHref($menu));

                $em = $this->getDoctrine()->getManager();
                $em->persist($menu);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Pozycja menu została zmieniona');

                return $this->redirectToRoute('admin_menu_edit',['id'=>$id]);
            }

            return $this->render('back/menu_edit.html.twig',array(
                'menu'=> $menu,
                'form'=> $form->createView()
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Pozycja menu nie została zmieniona');

            return $this->redirectToRoute('admin_menus');
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request){

        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menu->setHref($this->generateHref($menu));
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Pozycja menu została dodana');

            return $this->redirectToRoute('admin_menu_edit',array('id'=>$menu->getId()));
        }

        return $this->render('back/menu_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param Menu $menu
     * @return null|string
     */
    public function generateHref(Menu $menu): ?string
    {
        switch($menu->getType()){
            case 'article':
                $href = $this->generateUrl('front_menu_article_show',['menuName' => $menu->getName(),'id' => $menu->getArticle()->getId()]);
                break;
            case 'category':
                $href = $this->generateUrl('front_menu_articles_show_by_category',['menuName' => $menu->getName(),'categoryId' => $menu->getCategory()->getId()]);
                break;
            case 'href':
                $href = $menu->getHref();
                break;
            default:
                $href = false;
        }
        $href = str_replace('','_',$href);
        $href = str_replace('%20','_',$href);

        return $href;
    }

    /**
     * @param int $id
     * @param $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, $status)    {
        $menu = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->find($id);
        $menu->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($menu);
        $em->flush();

        if($status == 1){
            $this->session->getFlashBag()->add('success', 'Pozycja menu została wyłączona');
        }else {
            $this->session->getFlashBag()->add('success', 'Pozycja menu nie została wyłączona');
        }

        return $this->redirectToRoute('admin_menus');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changePosition(Request $request)
    {
        $id = $request->get('id');
        $position = $request->get('position');
        $menu = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $menu->setPosition($position);
        $em->persist($menu);
        $em->flush();$this->session->getFlashBag()->add('success', 'Pozycja została zmieniona');

        return $this->redirectToRoute('admin_menus');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $menu = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($menu);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Pozycja menu została usunięta');

        return $this->redirectToRoute('admin_menus');
    }

    /**
     * @return Response
     */
    public function index()
    {
        $menus = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->findBy(['parent' => null],['position' => 'ASC', 'id' => 'DESC']);

        return $this->render('back/menus.html.twig',array(
            'menus'=> $menus
        ));
    }
}
