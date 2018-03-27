<?php
namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName("Test category");
        $category->setDescription("This category will contain some test articles");
        $manager->persist($category);

        $this->addReference('category', $category);
        $manager->flush();
    }
}
