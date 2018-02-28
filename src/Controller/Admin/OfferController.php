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
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @return Response
     */
    public function show($id)
    {
        $offer = $this->getDoctrine()
            ->getRepository(Offer::class)
            ->find($id);

        return $this->render('back/offer_show.html.twig',array(
            'offer'=> $offer
        ));
    }

    /**
     * @return Response
     */
    public function edit($id, Request $request)    {
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
     * @return Response
     */
    public function disable($id, $status)    {
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
     * @return Response
     */
    public function delete($id)    {
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
