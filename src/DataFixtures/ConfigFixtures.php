<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Config;

class ConfigFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $config = new Config();
        $config->setId(1);
        $config->setTitle('Super site made by shinoks');
        $config->setEmail('youremail@gr8companydomain.com');
        $config->setPhone(999888777);
        $config->setAddress('43-250 City, ul. Good 5/4');
        $config->setLogoMain('img/logo-ss.png');
        $config->setLogoAdmin('img/logo-ssw.png');
        $config->setDescription("Yes this is super super change this to your's heart content");
        $config->setKeywords("site, cms, shinoks, php, admin, user");

        $manager->persist($config);
        $manager->flush();
    }
}
