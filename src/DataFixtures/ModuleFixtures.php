<?php
namespace App\DataFixtures;

use App\Entity\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ModuleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $module_top = $this->getReference('position_top');
        $module_bottom = $this->getReference('position_bottom');
        $genus_slider = $this->getReference('genus_slider');
        $genus_html = $this->getReference('genus_html');
        $genus_map = $this->getReference('genus_map');
        $menu1 = $this->getReference('menu_1');
        $menu2 = $this->getReference('menu_2');
        $menu_contact = $this->getReference('menu_contact');

        $module = new Module();
        $module->setName("Slider on front");
        $module->setPosition($module_top);
        $module->setGenus($genus_slider);
        $module->addMenu($menu1);
        $module->addMenu($menu2);
        $module->setSequence(1);
        $module->setVariable(['img/slide1/slider-image-1.jpg']);
        $module->setVariable(['img/slide1/slider-image-2.jpg']);
        $module->setVariable(['img/slide1/slider-image-4.jpg']);
        $module->setIsActive(1);
        $manager->persist($module);

        $module = new Module();
        $module->setName("Raw html on contact front");
        $module->setPosition($module_top);
        $module->setGenus($genus_html);
        $module->addMenu($menu_contact);
        $module->setSequence(2);
        $module->setIsActive(1);
        $manager->persist($module);

        $module = new Module();
        $module->setName("Google maps");
        $module->setPosition($module_bottom);
        $module->setGenus($genus_map);
        $module->addMenu($menu_contact);
        $module->setSequence(2);
        $module->setIsActive(1);
        $manager->persist($module);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(ModulePositionFixtures::class,ModuleGenusFixtures::class,MenuFixtures::class);
    }
}
