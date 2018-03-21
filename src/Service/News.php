<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;

class News
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * News constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerinterface $em)
    {
        $this->em = $em;
        $this->numberOfNews = 3;
    }

    /**
     * @return array|null
     */
    public function getLatestNews(): ?array
    {
        $latestNews = $this->em->getRepository(Article::class)->findBy([],['created' => 'DESC'],$this->numberOfNews);

        return $latestNews;
    }
}
