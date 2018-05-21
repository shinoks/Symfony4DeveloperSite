<?php
namespace App\DataFixtures;

use App\Entity\Realization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RealizationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $realization = new Realization();
        $realization->setName("Goood Home");
        $realization->setMainImage("img/default-property.jpg");
        $realization->setFolderWithImages("good_home");
        $realization->setSellingPrice("100000");
        $realization->setCurrency("PLN");
        $realization->setVolume("resell");
        $realization->setYardage("300");
        $realization->setCity("Warszawa");
        $realization->setRooms("10");
        $basic =[];
        $basic[] = "good looking";
        $basic[] = "nice location";
        $media = [];
        $media[] = "water cool/warm";
        $media[] = "sat tv";
        $security = [];
        $security[] = "camera";
        $security[] = "bodyguard";
        $realization->setBasic($basic);
        $realization->setMedia($media);
        $realization->setSecurity($security);
        $realization->setDescription("Very nice house, Located in the middle of Warszaw ...");
        $realization->setIsActive(1);
        $manager->persist($realization);

        $realization = new Realization();
        $realization->setName("Goood Home 2");
        $realization->setMainImage("img/default-property.jpg");
        $realization->setFolderWithImages("good_home");
        $realization->setSellingPrice("20000");
        $realization->setCurrency("USD");
        $realization->setVolume("resell");
        $realization->setYardage("300");
        $realization->setCity("Opole");
        $realization->setRooms("5");
        $basic =[];
        $basic[] = "nice location";
        $media = [];
        $media[] = "water cool/warm";
        $media[] = "sat tv";
        $security = [];
        $security[] = "camera";
        $realization->setBasic($basic);
        $realization->setMedia($media);
        $realization->setSecurity($security);
        $realization->setDescription("Very <b>nice</b> house, Located sfas asf a sfasf as f ...");
        $realization->setIsActive(1);
        $manager->persist($realization);

        $realization = new Realization();
        $realization->setName("Goood Home 3");
        $realization->setMainImage("img/default-property.jpg");
        $realization->setFolderWithImages("good_home");
        $realization->setSellingPrice("235000");
        $realization->setCurrency("PLN");
        $realization->setVolume("developer");
        $realization->setYardage("50");
        $realization->setCity("Sopot");
        $realization->setRooms("3");
        $basic =[];
        $basic[] = "nice location";
        $media = [];
        $media[] = "water cool/warm";
        $realization->setBasic($basic);
        $realization->setMedia($media);
        $realization->setDescription("house, Located sfas asf a sfasf as f ...");
        $realization->setIsActive(1);
        $manager->persist($realization);

        $manager->flush();
    }
}
