<?php
namespace App\Controller\Admin;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\CategoryType;

class CategoryController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
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
            'categories'=> $categories
        ));
    }

    /**
     * @return Response
     */
    public function show($id)
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
    public function new(Request $request){

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
    public function edit($id, Request $request)    {
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
                    'form'=> $form->createView()
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
    public function disable($id, $status)    {
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
    public function delete($id)    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Kategoria został usunięty');

        return $this->redirectToRoute('admin_categories');
    }
}
