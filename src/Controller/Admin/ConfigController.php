<?php
namespace App\Controller\Admin;

use App\Entity\Config;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\ConfigType;

class ConfigController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * ConfigController constructor.
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
        $config = $this->getDoctrine()
            ->getRepository(Config::class)
            ->find(1);

        return $this->render('back/config.html.twig',array(
            'configuration'=> $config
        ));
    }

    /**
     * @return Response
     */
    public function edit(Request $request)    {
        $config = $this->getDoctrine()
            ->getRepository(Config::class)
            ->find(1);
        if($config){
            $form = $this->createForm(ConfigType::class, $config);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $config = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($config);
                $em->flush();

                $this->session->getFlashBag()->add('success', 'Konfiguracja została zmieniona');

                return $this->render('back/config_edit.html.twig',array(
                    'configuration'=> $config,
                    'form'=> $form->createView()
                ));
            }

            return $this->render('back/config_edit.html.twig',array(
                'configuration'=> $config,
                'form'=> $form->createView()
            ));
        }else {

            $this->session->getFlashBag()->add('danger', 'Konfiguracja nie została znaleziona');

            return $this->redirectToRoute('admin_config');
        }
    }

}
