<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{
    /**
     * @return Response
     */
    public function startPage()
    {
        return $this->render('front/start.html.twig',array());
    }

    /**
     * @return Response
     */
    public function contactPage()
    {
        return $this->render('front/contact.html.twig',array());
    }
}
