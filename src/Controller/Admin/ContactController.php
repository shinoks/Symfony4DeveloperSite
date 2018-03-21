<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Contact;

class ContactController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * ContactController constructor.
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
        $contacts = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->findAllDesc();

        return $this->render('back/contacts.html.twig',array(
            'contacts'=> $contacts
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
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
