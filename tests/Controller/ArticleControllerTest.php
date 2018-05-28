<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class ArticleControllerTest extends WebTestCase
{
    public function testArticle()
    {
        $article = new Article();
        $article->setName('Super artykuł');
        $article->setText('Bardzo długi text');

        $articleRepository = $this->createMock(ObjectRepository::class);
        $articleRepository->expects($this->any())
            ->method('find')
            ->willReturn($article);

        $objectManager = $this->createMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($articleRepository);

        $this->assertEquals('Super artykuł', $articleRepository->find('Super artykuł')->getName());
    }
}
