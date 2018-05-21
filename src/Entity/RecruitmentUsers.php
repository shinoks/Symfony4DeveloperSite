<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecruitmentUsersRepository")
 */
class RecruitmentUsers
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
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="recruitmentUsers")
     * @ORM\JoinColumn()
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recruitment", inversedBy="recruitmentUsers")
     * @ORM\JoinColumn()
     */
    private $recruitment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RecruitmentUserStatus", inversedBy="recruitmentUsers")
     * @ORM\JoinColumn()
     */
    private $status;

    /**
     * @ORM\Column(type="string")
     */
    private $declaredAmount;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $payedAmount;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $payedDate;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $investmentPeriod;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $interest;

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
        $this->payedDate = NULL;
        $this->created = new \DateTime("now");
        $this->isActive = 1;
        $this->number = uniqid();
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
    public function getNumber()
    {
        return $this->number;
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
    public function getRecruitment()
    {
        return $this->recruitment;
    }

    /**
     * @param mixed $recruitment
     */
    public function setRecruitment($recruitment)
    {
        $this->recruitment = $recruitment;
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
    public function getDeclaredAmount()
    {
        return $this->declaredAmount;
    }

    /**
     * @param mixed $declaredAmount
     */
    public function setDeclaredAmount($declaredAmount)
    {
        $this->declaredAmount = $declaredAmount;
    }

    /**
     * @return mixed
     */
    public function getPayedAmount()
    {
        return $this->payedAmount;
    }

    /**
     * @param mixed $payedAmount
     */
    public function setPayedAmount($payedAmount)
    {
        $this->payedAmount = $payedAmount;
    }

    /**
     * @return mixed
     */
    public function getPayedDate()
    {
        return $this->payedDate;
    }

    /**
     * @param mixed $payedDate
     */
    public function setPayedDate($payedDate)
    {
        $this->payedDate = $payedDate;
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
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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
