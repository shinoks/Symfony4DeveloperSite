<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Offer;
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
    public function new(Request $request){

        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setOfferNumber($this->getUser()->getId().'/'.uniqid());
            $offer->setUser($this->getUser());
            switch($offer->getPeriod()){
                case '12':
                    $offer->setInterest(8);
                break;
                case '24':
                    $offer->setInterest(10);
                break;
            }
            $offer->setStatus('Oferta');
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();

            $this->session->getFlashBag()->add('success', 'Oferta została dodana');

            return $this->redirectToRoute('front_user_account');
        }

        return $this->render('front/offer_new.html.twig',array(
            'form'=> $form->createView()
        ));
    }
}
