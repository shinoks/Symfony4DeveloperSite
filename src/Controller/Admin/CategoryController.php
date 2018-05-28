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
    /**
     * @var Session
     */
    private $session;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function categories(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Category::class)->findBy([],[
            $request->query->get('sort','id')=>$request->query->get('direction','desc')
        ]);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)
        );


        return $this->render('back/categories.html.twig',array(
            'pagination'=> $pagination
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        return $this->render('back/category_show.html.twig',array(
            'category'=> $category
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
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
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)    {
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
     * @param int $id
     * @param $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, $status)    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        $category->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Kategoria została wyłączona');

        return $this->redirectToRoute('admin_categories');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Kategoria została usunięta');

        return $this->redirectToRoute('admin_categories');
    }
}
