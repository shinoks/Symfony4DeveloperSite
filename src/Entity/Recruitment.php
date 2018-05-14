<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecruitmentRepository")
 */
class Recruitment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     */
    private $desiredAmount;

    /**
     * @ORM\Column(type="integer")
     */
    private $investmentPeriod;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $interest;

    /**
     * @ORM\Column(type="string")
     */
    private $investmentType;

    /**
     * @ORM\Column(type="integer")
     */
    private $rooms;

    /**
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RecruitmentStatus", inversedBy="recruitments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->number = uniqid();
        $this->created = new \DateTime("now");
        $this->isActive = true;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getDesiredAmount()
    {
        return $this->desiredAmount;
    }

    /**
     * @param mixed $desiredAmount
     */
    public function setDesiredAmount($desiredAmount)
    {
        $this->desiredAmount = $desiredAmount;
    }

    /**
     * @return mixed
     */
    public function getInvestmentPeriod()
    {
        return $this->investmentPeriod;
    }

    /**
     * @param mixed $investmentPeriod
     */
    public function setInvestmentPeriod($investmentPeriod)
    {
        $this->investmentPeriod = $investmentPeriod;
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
    public function getInvestmentType()
    {
        return $this->investmentType;
    }

    /**
     * @param mixed $investmentType
     */
    public function setInvestmentType($investmentType)
    {
        $this->investmentType = $investmentType;
    }

    /**
     * @return mixed
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param mixed $rooms
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
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
