<?php
namespace App\Controller\Admin;

use App\Entity\OfferStatus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\OfferStatusType;

class OfferStatusController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * OfferStatusController constructor.
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
        $offerStatuses = $this->getDoctrine()
            ->getRepository(OfferStatus::class)
            ->findAll();

        return $this->render('back/offer_statuses.html.twig',array(
            'offerStatuses'=> $offerStatuses
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $offerStatus = $this->getDoctrine()
            ->getRepository(OfferStatus::class)
            ->find($id);

        return $this->render('back/offer_status_show.html.twig',array(
            'offerStatus'=> $offerStatus
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $offerStatus = new OfferStatus();
        $form = $this->createForm(OfferStatusType::class, $offerStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($offerStatus);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Status oferty został zmieniony');

            return $this->redirectToRoute('admin_offer_status_edit',array('id'=>$offerStatus->getId()));
        }

        return $this->render('back/offer_status_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)    {
        $offerStatus = $this->getDoctrine()
            ->getRepository(OfferStatus::class)
            ->find($id);
        if($offerStatus){
            $form = $this->createForm(OfferStatusType::class, $offerStatus);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $offerStatus = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($offerStatus);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Oferta statusu została zmieniona');

                return $this->render('back/offer_status_edit.html.twig',array(
                    'offerStatus'=> $offerStatus,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/offer_status_edit.html.twig',array(
                'offerStatus'=> $offerStatus,
                'form'=> $form->createView()
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Status oferty nie został znaleziony');

            return $this->redirectToRoute('admin_offerStatuses');
        }
    }

    /**
     * @param int $id
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function disable(int $id, int $status)    {
        $offerStatus = $this->getDoctrine()
            ->getRepository(OfferStatus::class)
            ->find($id);
        $offerStatus->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($offerStatus);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Status oferty został wyłączony');

        return $this->redirectToRoute('admin_offerStatuses');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $offerStatus = $this->getDoctrine()
            ->getRepository(OfferStatus::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($offerStatus);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Status oferty został usunięty');

        return $this->redirectToRoute('admin_offerStatuses');
    }
}
