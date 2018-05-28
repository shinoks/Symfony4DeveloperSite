<?php
namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category = $this->getReference('category');

        $article = new Article();
        $article->setName("Test article 1");
        $article->setText("<h1>Some good test article nr 1</h1> Lorem ipsum ");
        $article->setShortText("Check it out");
        $article->setImage("img/slide1/slider-image-1.jpg");
        $article->setStart(1);
        $article->setIsActive(1);
        $article->setCategory($category);
        $manager->persist($article);

        $article = new Article();
        $article->setName("Test article 2");
        $article->setText("<h1>Some good test article nr 2</h1> Lorem ipsum ");
        $article->setShortText("Check it out");
        $article->setImage("img/slide1/slider-image-2.jpg");
        $article->setStart(1);
        $article->setIsActive(1);
        $article->setCategory($category);
        $manager->persist($article);

        $article = new Article();
        $article->setName("Test article 3");
        $article->setText("<h1>Some good test article nr 3</h1> Lorem ipsum ");
        $article->setShortText("Check it out");
        $article->setImage("img/slide1/slider-image-4.jpg");
        $article->setStart(1);
        $article->setIsActive(1);
        $article->setCategory($category);
        $manager->persist($article);

        $article = new Article();
        $article->setName("Test article 4");
        $article->setText("<h1>Some good test article nr 4</h1> Lorem ipsum ");
        $article->setShortText("Check it out");
        $article->setStart(1);
        $article->setIsActive(1);
        $article->setCategory($category);
        $manager->persist($article);
        $this->addReference('article', $article);

        $article = new Article();
        $article->setName("Regulations");
        $article->setText("<h1>Regulamin</h1> Lorem ipsum ");
        $article->setShortText("Check it out");
        $article->setStart(1);
        $article->setIsActive(1);
        $article->setCategory($category);
        $manager->persist($article);
        $this->addReference('regulations', $article);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(CategoryFixtures::class,);
    }
}
