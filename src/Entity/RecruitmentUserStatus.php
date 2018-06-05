<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecruitmentUserStatusRepository")
 */
class RecruitmentUserStatus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEndingOffer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFvMailed;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFvGenerated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMailed;

    /**
     * @ORM\Column(type="string")
     */
    private $mailTemplate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDisabling;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecruitmentUsers", mappedBy="status")
     */
    private $recruitmentUsers;

    public function __construct()
    {
        $this->recruitmentUsers = new ArrayCollection();
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
    public function getIsEndingOffer()
    {
        return $this->isEndingOffer;
    }

    /**
     * @param mixed $isEndingOffer
     */
    public function setIsEndingOffer($isEndingOffer): void
    {
        $this->isEndingOffer = $isEndingOffer;
    }

    /**
     * @return mixed
     */
    public function getIsFvMailed()
    {
        return $this->isFvMailed;
    }

    /**
     * @param mixed $isFvMailed
     */
    public function setIsFvMailed($isFvMailed): void
    {
        $this->isFvMailed = $isFvMailed;
    }

    /**
     * @return mixed
     */
    public function getIsFvGenerated()
    {
        return $this->isFvGenerated;
    }

    /**
     * @param mixed $isFvGenerated
     */
    public function setIsFvGenerated($isFvGenerated): void
    {
        $this->isFvGenerated = $isFvGenerated;
    }

    /**
     * @return mixed
     */
    public function getIsMailed()
    {
        return $this->isMailed;
    }

    /**
     * @param mixed $isMailed
     */
    public function setIsMailed($isMailed): void
    {
        $this->isMailed = $isMailed;
    }

    /**
     * @return mixed
     */
    public function getMailTemplate()
    {
        return $this->mailTemplate;
    }

    /**
     * @param mixed $mailTemplate
     */
    public function setMailTemplate($mailTemplate): void
    {
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * @return mixed
     */
    public function getIsDisabling()
    {
        return $this->isDisabling;
    }

    /**
     * @param mixed $isDisabling
     */
    public function setIsDisabling($isDisabling): void
    {
        $this->isDisabling = $isDisabling;
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

}
