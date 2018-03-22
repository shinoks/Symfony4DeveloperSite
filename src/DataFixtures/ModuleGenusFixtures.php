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
        $moduleGenus->setTemplate('front/modules/slider.html.twig');
        $manager->persist($moduleGenus);

        $moduleGenus = new ModuleGenus();
        $moduleGenus->setName('Html');
        $moduleGenus->setType('raw_html');
        $moduleGenus->setContent('<b>super site</b><br/>of course Lorem ipsum is there as well');
        $moduleGenus->setTemplate('front/modules/raw_html.html.twig');
        $manager->persist($moduleGenus);

        $moduleGenus = new ModuleGenus();
        $moduleGenus->setName('Latest realizations');
        $moduleGenus->setType('latest_realizations');
        $moduleGenus->setTemplate('front/modules/latest_realizations.html.twig');
        $manager->persist($moduleGenus);

        $manager->flush();
    }
}
