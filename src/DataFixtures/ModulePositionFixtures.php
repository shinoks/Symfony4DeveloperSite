<?php
namespace App\DataFixtures;

use App\Entity\ModulePosition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ModulePositionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $modulePosition = new ModulePosition();
        $modulePosition->setName('Top');
        $modulePosition->setPosition('top');
        $manager->persist($modulePosition);
        $this->addReference('position_top', $modulePosition);

        $modulePosition = new ModulePosition();
        $modulePosition->setName('Bottom');
        $modulePosition->setPosition('bottom');
        $manager->persist($modulePosition);
        $this->addReference('position_bottom', $modulePosition);

        $manager->flush();
    }
}
