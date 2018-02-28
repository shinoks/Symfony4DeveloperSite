<?php
namespace App\Controller\Admin;

use App\Entity\Realization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\RealizationType;

class RealizationController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function index()
    {
        $realizations = $this->getDoctrine()
            ->getRepository(Realization::class)
            ->findAll();

        return $this->render('back/realizations.html.twig',array(
            'realizations'=> $realizations
        ));
    }

    /**
     * @return Response
     */
    public function show($id)
    {
        $realization = $this->getDoctrine()
            ->getRepository(Realization::class)
            ->find($id);

        return $this->render('back/realization_show.html.twig',array(
            'realization'=> $realization
        ));
    }

    /**
     * @return Response
     */
    public function new(Request $request){

        $realization = new Realization();
        $form = $this->createForm(RealizationType::class, $realization);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($realization);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Realizacja została dodana');

            return $this->redirectToRoute('admin_realization_edit',array('id'=>$realization->getId()));
        }

        return $this->render('back/realization_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @return Response
     */
    public function edit($id, Request $request)    {
        $realization = $this->getDoctrine()
            ->getRepository(Realization::class)
            ->find($id);
        if($realization){
            $form = $this->createForm(RealizationType::class, $realization);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $realization = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($realization);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Realizacja została zmieniona');

                return $this->render('back/realization_edit.html.twig',array(
                    'realization'=> $realization,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/realization_edit.html.twig',array(
                'realization'=> $realization,
                'form'=> $form->createView()
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Realizacja nie została znaleziona');

            return $this->redirectToRoute('admin_realizations');
        }
    }

    /**
     * @return Response
     */
    public function disable($id, $status)    {
        $realization = $this->getDoctrine()
            ->getRepository(Realization::class)
            ->find($id);
        $realization->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($realization);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Realizacja została wyłączona');

        return $this->redirectToRoute('admin_realizations');
    }

    /**
     * @return Response
     */
    public function delete($id)    {
        $realization = $this->getDoctrine()
            ->getRepository(Realization::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($realization);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Realizacja została usunięta');

        return $this->redirectToRoute('admin_realizations');
    }
}
