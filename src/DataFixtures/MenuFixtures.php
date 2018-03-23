<?php
namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $menu = new Menu();
        $menu->setName('Start');
        $menu->setHref('/index');
        $menu->setType('href');
        $menu->setIsActive(1);
        $menu->setPosition(1);
        $menu->setInFooter(1);
        $menu->setInBottom(1);
        $manager->persist($menu);

        $menu = new Menu();
        $menu->setName('News');
        $menu->setHref('/news');
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

        $menu = new Menu();
        $menu->setName('About Us');
        $menu->setHref('/about_us');
        $menu->setType('href');
        $menu->setIsActive(1);
        $menu->setPosition(4);
        $menu->setInFooter(1);
        $menu->setInBottom(0);
        $manager->persist($menu);

        $menu = new Menu();
        $menu->setName('Contact');
        $menu->setHref('/contact');
        $menu->setType('href');
        $menu->setIsActive(1);
        $menu->setPosition(5);
        $menu->setInFooter(1);
        $menu->setInBottom(1);
        $manager->persist($menu);

        $manager->flush();
    }
}
