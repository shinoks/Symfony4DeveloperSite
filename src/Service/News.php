<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;

class News
{
    private $em;

    public function __construct(EntityManagerinterface $em)
    {
        $this->em = $em;
        $this->numberOfNews = 3;
    }

    public function getLatestNews() {
        $latestNews = $this->em->getRepository(Article::class)->findBy([],['created' => 'DESC'],$this->numberOfNews);

        return $latestNews;
    }
}
