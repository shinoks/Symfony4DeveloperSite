<?php
namespace App\DataFixtures;

use App\Entity\ModuleGenus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ModuleGenusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $moduleGenus = new ModuleGenus();
        $moduleGenus->setName('Image slider');
        $moduleGenus->setType('slider');
        $moduleGenus->setTemplate('slider.html.twig');
        $manager->persist($moduleGenus);

        $this->addReference('genus_slider', $moduleGenus);

        $moduleGenus = new ModuleGenus();
        $moduleGenus->setName('Html');
        $moduleGenus->setType('raw_html');
        $moduleGenus->setContent('<b>super site</b><br/>of course Lorem ipsum is there as well');
        $moduleGenus->setTemplate('raw_html.html.twig');
        $manager->persist($moduleGenus);
        $this->addReference('genus_html', $moduleGenus);

        $moduleGenus = new ModuleGenus();
        $moduleGenus->setName('Latest realizations');
        $moduleGenus->setType('latest_realizations');
        $moduleGenus->setTemplate('latest_realizations.html.twig');
        $manager->persist($moduleGenus);

        $moduleGenus = new ModuleGenus();
        $moduleGenus->setName('Google Map');
        $moduleGenus->setType('googl_map');
        $moduleGenus->setTemplate('google_map.html.twig');
        $manager->persist($moduleGenus);
        $this->addReference('genus_map', $moduleGenus);

        $manager->flush();
    }
}
