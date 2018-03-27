<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Finder\Finder;

class FileBrowserController extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * FileBrowserController constructor.
     */
    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @param null|string $dir
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function browseFiles(?string $dir = null)
    {
        $files = $this->getUploadedFilesInDir();
        $directories = $this->getUploadedDirectories();

        return $this->render('back/browse_files.html.twig',array(
            'files'=> $files,
            'directories'=> $directories
        ));
    }

    /**
     * @param string $dir
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function browseFilesInDir(string $dir)
    {
        $files = $this->getUploadedFilesInDir($dir);
        $directories = $this->getUploadedDirectories($dir);

        return $this->render('back/browse_files.html.twig',array(
            'files'=> $files,
            'directories'=> $directories
        ));
    }

    /**
     * @param null|string $dir
     * @return array|null
     */
    private function getUploadedFilesInDir(?string $dir = null): ?array
    {
        $finder = new Finder();
        $files = $finder->files()->in(['uploads/files/'.$dir]);
        $filenames = iterator_to_array($files,true);

        return $filenames;
    }

    /**
     * @param null|string $dir
     * @return array|null
     */
    private function getUploadedDirectories(?string $dir = null): ?array
    {
        $finder = new Finder();
        $files = $finder->directories()->in(['uploads/files/'.$dir]);
        $directories = iterator_to_array($files,true);

        return $directories;
    }

}
