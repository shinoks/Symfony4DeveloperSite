<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @return Response
     */
    public function startPage()
    {
        return $this->render('back/start.html.twig',array());
    }

    /**
     * @return Response
     */
    public function loginPage()
    {
        return $this->render('back/login.html.twig',array());
    }

}
