<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\ModulePosition;
use App\Form\ModulePositionType;

class ModulePositionController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * ModulePositionController constructor.
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
        $modulePosition = $this->getDoctrine()
            ->getRepository(ModulePosition::class)
            ->find($id);

        return $this->render('back/module_position_show.html.twig',array(
            'modulePosition'=> $modulePosition
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)
    {
        $modulePosition = $this->getDoctrine()
            ->getRepository(ModulePosition::class)
            ->find($id);
        if($modulePosition){
            $form = $this->createForm(ModulePositionType::class, $modulePosition);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $modulePosition = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($modulePosition);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Kategoria została zmieniona');

                return $this->render('back/module_position_edit.html.twig',array(
                    'modulePosition'=> $modulePosition,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/module_position_edit.html.twig',array(
                'modulePosition'=> $modulePosition,
                'form'=> $form->createView()
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Kategoria nie została znaleziona');

            return $this->redirectToRoute('admin_categories');
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $modulePosition = new ModulePosition();
        $form = $this->createForm(ModulePositionType::class, $modulePosition);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($modulePosition);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Artykuł został zmieniony');

            return $this->redirectToRoute('admin_module_position_edit',array('id'=>$modulePosition->getId()));
        }

        return $this->render('back/module_position_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)
    {
        $modulePosition = $this->getDoctrine()
            ->getRepository(ModulePosition::class)
            ->find($id);
        $modulePosition->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($modulePosition);
        $em->flush();

        if($status == 1){
            $this->session->getFlashBag()->add('success', 'Artykuł został włączony ze strony głównej');
        }else {
            $this->session->getFlashBag()->add('success', 'Artykuł został wyłączony ze strony głównej');
        }

        return $this->redirectToRoute('admin_module_positions');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)
    {
        $modulePosition = $this->getDoctrine()
            ->getRepository(ModulePosition::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($modulePosition);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Artykuł został usunięty');

        return $this->redirectToRoute('admin_module_positions');
    }

    /**
     * @return Response
     */
    public function index()
    {
        $modulePositions = $this->getDoctrine()
            ->getRepository(ModulePosition::class)
            ->findAll();

        return $this->render('back/module_positions.html.twig',array(
            'modulePositions'=> $modulePositions
        ));
    }
}
