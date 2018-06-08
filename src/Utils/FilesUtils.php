<?php
namespace App\Utils;

use App\Entity\Config;
use Doctrine\ORM\EntityManagerInterface;

class FilesUtils
{
    public function getFileUrl($name)
    {
        $url = $_SERVER['DOCUMENT_ROOT'].'/../public_html/attachement/' . $name;

        return $url;
    }
}
