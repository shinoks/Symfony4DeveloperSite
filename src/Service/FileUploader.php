<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * @var string
     */
    private $targetDir;
    /**
     * @var string
     */
    private $imageDir;

    /**
     * FileUploader constructor.
     * @param string $targetDir
     * @param string $imageDir
     */
    public function __construct(string $targetDir, string $imageDir)
    {
        $this->targetDir = $targetDir;
        $this->imageDir = $imageDir;
    }

    /**
     * @param UploadedFile|null $file
     * @return string
     */
    public function upload(UploadedFile $file = null)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->targetDir, $fileName);

        return $fileName;
    }

    /**
     * @return string
     */
    public function getTargetDir(): string
    {

        return $this->targetDir;
    }

    /**
     * @return string
     */
    public function getImageDir(): string
    {

        return $this->imageDir;
    }
}
