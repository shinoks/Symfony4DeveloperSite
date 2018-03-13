<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Finder\Finder;

class FileBrowserController extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function browseFiles($dir = null)
    {
        $files = $this->getUploadedFilesInDir();
        $directories = $this->getUploadedDirectories();

        return $this->render('back/browse_files.html.twig',array(
            'files'=> $files,
            'directories'=> $directories
        ));
    }

    public function browseFilesInDir($dir)
    {
        $files = $this->getUploadedFilesInDir($dir);
        $directories = $this->getUploadedDirectories($dir);

        return $this->render('back/browse_files.html.twig',array(
            'files'=> $files,
            'directories'=> $directories
        ));
    }

    private function getUploadedFilesInDir($dir = null)
    {
        $finder = new Finder();
        $files = $finder->files()->in(['uploads/files/'.$dir]);
        $filenames = iterator_to_array($files,true);

        return $filenames;
    }

    private function getUploadedDirectories($dir = null)
    {
        $finder = new Finder();
        $files = $finder->directories()->in(['uploads/files/'.$dir]);
        $directories = iterator_to_array($files,true);

        return $directories;
    }

}
