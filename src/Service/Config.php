<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Config as conf;
use App\Entity\Contact;

class Config
{
    private $em;

    public function __construct(EntityManagerinterface $em)
    {
        $this->em = $em;
    }

    public function getConfig() {
        $config = $this->em->getRepository(conf::class)->findOneBy(['id'=>1]);

        return $config;
    }

    public function getNotReadedMessages() {
        $contact = $this->em->getRepository(Contact::class)->CountAllNotReaded();

        return $contact;
    }
}
