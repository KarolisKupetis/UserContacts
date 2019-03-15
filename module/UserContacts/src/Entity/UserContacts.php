<?php

namespace UserContacts\Entity;

use Doctrine\ORM\Mapping as ORM;
use Users\Entity\User;

/**
 * @ORM\Entity(repositoryClass="UserContacts\Repository\UserContactsRepository")
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
     * @var string
     * @ORM\Column(type="string", length=256, name="phone_number")
     */
    private $phoneNumber;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="Users\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

}