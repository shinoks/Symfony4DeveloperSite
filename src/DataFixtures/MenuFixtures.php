<?php
namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MenuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category = $this->getReference('category');

        $menu = new Menu();
        $menu->setName('Start');
        $menu->setHref('/index');
        $menu->setType('href');
        $menu->setIsActive(1);
        $menu->setPosition(1);
        $menu->setInFooter(1);
        $menu->setInBottom(1);
        $manager->persist($menu);
        $this->addReference('menu_1', $menu);

        $menu = new Menu();
        $menu->setName('News');
        $menu->setHref('/news/index');
        $menu->setType('href');
        $menu->setIsActive(1);
        $menu->setPosition(2);
        $menu->setInFooter(1);
        $menu->setInBottom(0);
        $manager->persist($menu);

        $menu = new Menu();
        $menu->setName('Some categoryshow');
        $menu->setHref('/Some categoryshow/category/' . $category->getId());
        $menu->setType('href');
        $menu->setIsActive(1);
        $menu->setPosition(2);
        $menu->setInFooter(1);
        $menu->setInBottom(0);
        $manager->persist($menu);

        $menu = new Menu();
        $menu->setName('Realizations');
        $menu->setHref('/realization');
        $menu->setType('href');
        $menu->setIsActive(1);
        $menu->setPosition(3);
        $menu->setInFooter(0);
        $menu->setInBottom(0);
        $manager->persist($menu);
        $this->addReference('menu_2', $menu);

        $menu = new Menu();
        $menu->setName('Contact');
        $menu->setHref('/contact');
        $menu->setType('href');
        $menu->setIsActive(1);
        $menu->setPosition(5);
        $menu->setInFooter(1);
        $menu->setInBottom(1);
        $manager->persist($menu);
        $this->addReference('menu_contact', $menu);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(CategoryFixtures::class,);
    }
}
