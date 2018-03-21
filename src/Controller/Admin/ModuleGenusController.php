<?php
namespace App\Controller\Admin;

use App\Entity\ModuleGenus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\ModuleGenusType;

class ModuleGenusController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * ModuleGenusController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function index()
    {
        $moduleGenuses = $this->getDoctrine()
            ->getRepository(ModuleGenus::class)
            ->findAll();

        return $this->render('back/module_genuses.html.twig',array(
            'moduleGenuses'=> $moduleGenuses
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $moduleGenus = $this->getDoctrine()
            ->getRepository(ModuleGenus::class)
            ->find($id);

        return $this->render('back/module_genus_show.html.twig',array(
            'moduleGenus'=> $moduleGenus
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $moduleGenus = new ModuleGenus();
        $form = $this->createForm(ModuleGenusType::class, $moduleGenus);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($moduleGenus);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Nowy typ modułu został stworzony');

            return $this->redirectToRoute('admin_module_genus_edit',array('id'=>$moduleGenus->getId()));
        }

        return $this->render('back/module_genus_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)    {
        $moduleGenus = $this->getDoctrine()
            ->getRepository(ModuleGenus::class)
            ->find($id);
        if($moduleGenus){
            $form = $this->createForm(ModuleGenusType::class, $moduleGenus);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $moduleGenus = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($moduleGenus);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Typ modułu został zminiony');

                return $this->render('back/module_genus_edit.html.twig',array(
                    'moduleGenus'=> $moduleGenus,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/module_genus_edit.html.twig',array(
                'moduleGenus'=> $moduleGenus,
                'form'=> $form->createView()
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Typ nie został znaleziony');

            return $this->redirectToRoute('admin_module_genuses');
        }
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $moduleGenus = $this->getDoctrine()
            ->getRepository(ModuleGenus::class)
            ->find($id);
        $moduleGenus->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($moduleGenus);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Typ modułu został wyłączony');

        return $this->redirectToRoute('admin_module_genuses');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $moduleGenus = $this->getDoctrine()
            ->getRepository(ModuleGenus::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($moduleGenus);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Typ modułu został usunięty');

        return $this->redirectToRoute('admin_module_genuses');
    }
}
