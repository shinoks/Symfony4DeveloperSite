<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $gender;

    /**
     * @ORM\Column(type="bigint", unique=true, nullable=true)
     */
    private $pesel;

    /**
     * @ORM\Column(type="string", length=9, unique=true, nullable=true)
     */
    private $idNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     */
    private $bankAccount;

    /**
     * @ORM\Column(type="boolean")
     */
    private $regulations;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $regulationFromOffer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $regulationFromRegister;

    /**
     * @ORM\Column(type="boolean")
     */
    private $marketingRegulations;

    /**
     * @ORM\Column(type="string", length=35, nullable=true)
     */
    private $hash;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = array();

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnabledByAdmin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offer", mappedBy="user")
     */
    private $offers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Opinions", mappedBy="user")
     */
    private $opinions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RecruitmentUsers", mappedBy="user")
     */
    private $recruitmentUsers;

    public function __construct()
    {
        $this->isActive = true;
        $this->isEnabledByAdmin = true;
        $this->offers = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getIsActive(): bool
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
    public function getisEnabledByAdmin()
    {
        return $this->isEnabledByAdmin;
    }

    /**
     * @param mixed $isEnabledByAdmin
     */
    public function setIsEnabledByAdmin($isEnabledByAdmin)
    {
        $this->isEnabledByAdmin = $isEnabledByAdmin;
    }

    public function getSalt()
    {
        return null;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getPesel()
    {
        return $this->pesel;
    }

    /**
     * @param mixed $pesel
     */
    public function setPesel($pesel)
    {
        $this->pesel = $pesel;
    }

    /**
     * @return mixed
     */
    public function getIdNumber()
    {
        return $this->idNumber;
    }

    /**
     * @param mixed $idNumber
     */
    public function setIdNumber($idNumber)
    {
        $this->idNumber = $idNumber;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
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
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @param mixed $bankAccount
     */
    public function setBankAccount($bankAccount): void
    {
        $this->bankAccount = $bankAccount;
    }

    /**
     * @return mixed
     */
    public function getRegulations()
    {
        return $this->regulations;
    }

    /**
     * @param mixed $regulations
     */
    public function setRegulations($regulations)
    {
        $this->regulations = $regulations;
    }

    /**
     * @return mixed
     */
    public function getRegulationFromRegister()
    {
        return $this->regulationFromRegister;
    }

    /**
     * @param mixed $regulationFromRegister
     */
    public function setRegulationFromRegister($regulationFromRegister)
    {
        $this->regulationFromRegister = $regulationFromRegister;
    }

    /**
     * @return mixed
     */
    public function getRegulationFromOffer()
    {
        return $this->regulationFromOffer;
    }

    /**
     * @param mixed $regulationFromOffer
     */
    public function setRegulationFromOffer($regulationFromOffer)
    {
        $this->regulationFromOffer = $regulationFromOffer;
    }

    /**
     * @return mixed
     */
    public function getMarketingRegulations()
    {
        return $this->marketingRegulations;
    }

    /**
     * @param mixed $marketingRegulations
     */
    public function setMarketingRegulations($marketingRegulations): void
    {
        $this->marketingRegulations = $marketingRegulations;
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     * @return mixed
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return array_unique($this->roles);
    }

    /**
     * @return mixed
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * @return mixed
     */
    public function getComments(): ?array
    {
        return $this->comments;
    }

    /**
     * @return mixed
     */
    public function getOpinions()
    {
        return $this->opinions;
    }

    /**
     * @param mixed $opinions
     */
    public function setOpinions($opinions): void
    {
        $this->opinions = $opinions;
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

    public function eraseCredentials()
    {
    }
    public function isAccountNonExpired(): bool
    {
        return true;
    }

    public function isAccountNonLocked(): bool
    {
        return true;
    }

    public function isCredentialsNonExpired(): bool
    {
        return true;
    }

    public function isEnabled(): bool
    {
        return $this->isActive;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->firstName,
            $this->lastName,
            $this->isActive
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->firstName,
            $this->lastName,
            $this->isActive
            ) = unserialize($serialized);
    }
}
