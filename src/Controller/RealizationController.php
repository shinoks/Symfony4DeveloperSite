<?php
namespace App\Controller;

use App\Entity\Realization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Finder\Finder;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;

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

        return $this->render('front/realizations.html.twig',array(
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
        $images = $this->getUploadedFilesInDir('test');

        return $this->render('front/realization_show.html.twig',array(
            'realization'=> $realization,
            'images' => $images
        ));
    }

    private function getUploadedFilesInDir($dir)
    {
        $finder = new Finder();
        $files = $finder->files()->in(['uploads/files/'.$dir]);
        $filenames = iterator_to_array($files,true);

        return $filenames;
    }
}
