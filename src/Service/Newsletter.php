<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Newsletter
{
    private $em;

    public function __construct(EntityManagerinterface $em)
    {
        $this->em = $em;
    }

}
