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
    /**
     * @var Session
     */
    private $session;

    /**
     * RealizationController constructor.
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
        $realizations = $this->getDoctrine()
            ->getRepository(Realization::class)
            ->findAll();

        return $this->render('front/realizations.html.twig',array(
            'realizations'=> $realizations
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $realization = $this->getDoctrine()
            ->getRepository(Realization::class)
            ->find($id);
        $images = $this->getUploadedFilesInDir($realization->getFolderWithImages());

        return $this->render('front/realization_show.html.twig',array(
            'realization'=> $realization,
            'images' => $images
        ));
    }

    /**
     * @param null|string $dir
     * @return array|null
     */
    private function getUploadedFilesInDir(?string $dir): ?array
    {
        $finder = new Finder();
        $files = $finder->files()->in(['uploads/files/'.$dir]);
        $filenames = iterator_to_array($files,true);

        return $filenames;
    }

    /**
     * @param int $limit
     * @return Response
     */
    public function getLatestRealizations(int $limit): response
    {
        $latestRealizations = $this->getDoctrine()
            ->getRepository(Realization::class)
            ->findBy(['isActive' => 1],['id' => 'desc'],$limit);

        return $this->render('front/addons/items.html.twig',[
            'latestRealizations'=> $latestRealizations
        ]);
    }
}
