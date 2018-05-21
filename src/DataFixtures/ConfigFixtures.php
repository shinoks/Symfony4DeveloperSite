<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Config;
use Test\Fixture\Entity\Article;

class ConfigFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $regulations = $this->getReference('regulations');

        $config = new Config();
        $config->setId(1);
        $config->setTitle('Super site made by shinoks');
        $config->setEmail('youremail@gr8companydomain.com');
        $config->setPhone(999888777);
        $config->setAddress('43-250 City, ul. Good 5/4');
        $config->setLogoMain('img/logo-ss.png');
        $config->setLogoAdmin('img/logo-ssw.png');
        $config->setRegulationsUrl('article/'.$regulations->getId());
        $config->setDescription("Yes this is super super change this to your's heart content");
        $config->setKeywords("site, cms, shinoks, php, admin, user");

        $manager->persist($config);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(ArticleFixtures::class);
    }
}
