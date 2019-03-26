<?php

namespace UserDetails\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use User\Entity\User;

/**
 * @ORM\Entity(repositoryClass="UserDetails\Repository\UserContactsRepository")
 * @ORM\Table(name="user_contacts")
 */
class UserContacts
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @var int
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=256, name = "address")
     */
    private $address;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserDetails\Entity\UserPhoneNumber", mappedBy="userContacts")
     */
    private $phoneNumbers;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    public function __construct()
    {
        $this->phoneNumbers=new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhoneNumbers(): ArrayCollection
    {
        return $this->phoneNumbers;
    }

    /**
     * @param ArrayCollection $phoneNumbers
     */
    public function setPhoneNumbers(ArrayCollection $phoneNumbers): void
    {
        $this->phoneNumbers = $phoneNumbers;
    }

    /**
     * @param UserPhoneNumber $phoneNumber
     */
    public function addPhoneNumber(UserPhoneNumber $phoneNumber):void
    {
        $this->phoneNumbers->add($phoneNumber);
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }



}