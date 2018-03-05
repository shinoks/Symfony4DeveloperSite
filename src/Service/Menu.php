<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Menu as Men;

class Menu
{
    private $em;

    public function __construct(EntityManagerinterface $em)
    {
        $this->em = $em;
    }

    public function getMenu() {
        $menu = $this->em->getRepository(Men::class)->findBy(['isActive' => 1, 'parent' => null]);

        return $menu;
    }
}
