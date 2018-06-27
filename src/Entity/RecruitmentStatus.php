<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecruitmentStatusRepository")
 */
class RecruitmentStatus
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

    private $isMailedToAdmin;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mailAdminTemplate;

    /**
     * @ORM\Column(type="boolean")
     */

    private $isMailedToUsers;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mailUsersTemplate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVisibleToUsers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Recruitment", mappedBy="status")
     */
    private $recruitments;

    public function __construct()
    {
        $this->recruitments = new ArrayCollection();
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
    public function getisMailedToAdmin()
    {
        return $this->isMailedToAdmin;
    }

    /**
     * @param mixed $isMailedToAdmin
     */
    public function setIsMailedToAdmin($isMailedToAdmin): void
    {
        $this->isMailedToAdmin = $isMailedToAdmin;
    }

    /**
     * @return mixed
     */
    public function getMailAdminTemplate()
    {
        return $this->mailAdminTemplate;
    }

    /**
     * @param mixed $mailAdminTemplate
     */
    public function setMailAdminTemplate($mailAdminTemplate): void
    {
        $this->mailAdminTemplate = $mailAdminTemplate;
    }

    /**
     * @return mixed
     */
    public function getisMailedToUsers()
    {
        return $this->isMailedToUsers;
    }

    /**
     * @param mixed $isMailedToUsers
     */
    public function setIsMailedToUsers($isMailedToUsers): void
    {
        $this->isMailedToUsers = $isMailedToUsers;
    }

    /**
     * @return mixed
     */
    public function getMailUsersTemplate()
    {
        return $this->mailUsersTemplate;
    }

    /**
     * @param mixed $mailUsersTemplate
     */
    public function setMailUsersTemplate($mailUsersTemplate): void
    {
        $this->mailUsersTemplate = $mailUsersTemplate;
    }

    /**
     * @return mixed
     */
    public function getisVisibleToUsers()
    {
        return $this->isVisibleToUsers;
    }

    /**
     * @param mixed $isVisibleToUsers
     */
    public function setIsVisibleToUsers($isVisibleToUsers): void
    {
        $this->isVisibleToUsers = $isVisibleToUsers;
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

    /**
     * @return mixed
     */
    public function getRecruitments()
    {
        return $this->recruitments;
    }

    /**
     * @param mixed $recruitments
     */
    public function setRecruitments($recruitments)
    {
        $this->recruitments = $recruitments;
    }

}
