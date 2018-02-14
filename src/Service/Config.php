<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Config as conf;

class Config
{
    private $config;

    public function __construct(EntityManagerinterface $config)
    {
        $this->config = $config;
    }

    public function getConfig() {
        $config = $this->config->getRepository(conf::class)->findOneBy(['id'=>1]);

        return $config;
    }

}
