<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecruitmentRepository")
 */
class Recruitment implements \ArrayAccess
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $paymentTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecruitmentUsers", mappedBy="recruitment")
     */
    private $recruitmentUsers;

    public function __construct()
    {
        $this->number = uniqid();
        $this->created = new \DateTime("now");
        $this->isActive = true;
        $this->paymentTime = NULL;
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
    public function getPaymentTime()
    {
        return $this->paymentTime;
    }

    /**
     * @param mixed $paymentTime
     */
    public function setPaymentTime($paymentTime)
    {
        $this->paymentTime = $paymentTime;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
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

    /**
     * @return mixed
     */
    public function getRecruitmentUsers()
    {
        return $this->recruitmentUsers;
    }

    /**
     * @param mixed $recruitmentUsers
     */
    public function setRecruitmentUsers($recruitmentUsers)
    {
        $this->recruitmentUsers = $recruitmentUsers;
    }

    public function offsetExists($offset) {

        return isset($this->$offset);
    }

    public function offsetSet($offset, $value) {
        $this->$offset = $value;
    }

    public function offsetGet($offset) {

        return $this->$offset;
    }

    public function offsetUnset($offset) {
        $this->$offset = null;
    }
}
