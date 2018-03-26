<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Social as so;

class Social
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Social constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerinterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return array|null
     */
    public function getSocial(): ?array
    {
        $social = $this->em->getRepository(so::class)->findBy(['isActive' => 1]);

        return $social;
    }
}
