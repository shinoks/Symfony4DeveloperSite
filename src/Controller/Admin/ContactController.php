<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Contact;
use App\Repository\ContactRepository;

class ContactController extends Controller
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
        $contacts = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->findAllDesc();

        return $this->render('back/contacts.html.twig',array(
            'contacts'=> $contacts
        ));
    }

    /**
     * @return Response
     */
    public function show($id)
    {
        $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($id);
        if($contact->getReaded()==0){
            $contact->setReaded(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
        }

        return $this->render('back/contact_show.html.twig',array(
            'contact'=> $contact
        ));
    }

}