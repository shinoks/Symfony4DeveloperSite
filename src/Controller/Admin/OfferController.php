<?php
namespace App\Controller\Admin;

use App\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\OfferType;

class OfferController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * OfferController constructor.
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
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($id);

        return $this->render('back/offer_show.html.twig',array(
            'offer'=> $offer
        ));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function edit(int $id, Request $request)
    {
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($id);
        if($offer){
            $form = $this->createForm(OfferType::class, $offer);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $offer = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($offer);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Oferta została zmieniona');

                return $this->redirectToRoute('admin_offer_edit',['id'=> $id]);
            }

            return $this->render('back/offer_edit.html.twig',array(
                'offer'=> $offer,
                'form'=> $form->createView()
            ));
        }else {
            $this->session->getFlashBag()->add('danger', 'Ofrta nie została znaleziona');

            return $this->redirectToRoute('admin_offerts');
        }

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $offer = new Offer;
        $form = $this->createForm(OfferType::class, $offer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Oferta została dodana');

            return $this->redirectToRoute('admin_offer_edit',['id'=> $offer->getId()]);
        }

        return $this->render('back/offer_new.html.twig',array(
            'offer'=> $offer,
            'form'=> $form->createView()
        ));
    }

    /**
     * @return Response
     */
    public function disable(int $id, int $status)
    {
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($id);
        $offer->setIsActive($status);

        $em = $this->getDoctrine()->getManager();
        $em->persist($offer);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Oferta została wyłączona');

        return $this->redirectToRoute('admin_offerts');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(int $id)    {
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($offer);
        $em->flush();

        $this->session->getFlashBag()->add('success', 'Oferta została usunięta');

        return $this->redirectToRoute('admin_offerts');
    }

    /**
     * @return Response
     */
    public function index()
    {
        $offerts = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->findAll();

        return $this->render('back/offerts.html.twig',array(
            'offerts'=> $offerts
        ));
    }
}
