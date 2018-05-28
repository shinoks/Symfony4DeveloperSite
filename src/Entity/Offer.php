<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $offerNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="offers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="integer")
     */
    private $ammount;

    /**
     * @ORM\Column(type="integer")
     */
    private $interest;

    /**
     * @ORM\Column(type="integer")
     */
    private $period;

    /**
     * @ORM\Column(type="integer")
     */
    private $settlement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OfferStatus", inversedBy="offerts")
     * @ORM\JoinColumn(nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->created = new \DateTime("now");
        $this->isActive= 1;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getOfferNumber()
    {
        return $this->offerNumber;
    }

    /**
     * @param mixed $offerNumber
     */
    public function setOfferNumber($offerNumber)
    {
        $this->offerNumber = $offerNumber;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getAmmount()
    {
        return $this->ammount;
    }

    /**
     * @param mixed $ammount
     */
    public function setAmmount($ammount)
    {
        $this->ammount = $ammount;
    }

    /**
     * @return mixed
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * @param mixed $interest
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;
    }

    /**
     * @return mixed
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param mixed $period
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * @return mixed
     */
    public function getSettlement()
    {
        return $this->settlement;
    }

    /**
     * @param mixed $settlement
     */
    public function setSettlement($settlement)
    {
        $this->settlement = $settlement;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

}
