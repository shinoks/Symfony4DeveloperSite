<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Config as conf;
use App\Entity\Contact;

class Config
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Config constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerinterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return conf
     */
    public function getConfig(): conf
    {
        $config = $this->em->getRepository(conf::class)->findOneBy(['id'=>1]);

        return $config;
    }

    /**
     * @return array
     */
    public function getNotReadedMessages(): array
    {
        $contact = $this->em->getRepository(Contact::class)->CountAllNotReaded();

        return $contact;
    }
}
