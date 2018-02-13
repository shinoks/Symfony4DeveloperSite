<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;
    private $imageDir;

    public function __construct($targetDir,$imageDir)
    {
        $this->targetDir = $targetDir;
        $this->imageDir = $imageDir;
    }

    public function upload(UploadedFile $file = null)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->targetDir, $fileName);

        return $fileName;
    }

    public function getTargetDir() {
        return $this->targetDir;
    }

    public function getImageDir() {
        return $this->imageDir;
    }
}
