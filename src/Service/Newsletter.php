<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Newsletter
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Newsletter constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerinterface $em)
    {
        $this->em = $em;
    }

}
