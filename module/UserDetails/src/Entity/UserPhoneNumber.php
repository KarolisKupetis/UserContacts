<?php


namespace UserDetails\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="phone_numbers")
 */
class UserPhoneNumber
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @var int
     */
    private $id;

    /**
     * @var UserContacts
     * @ORM\ManyToOne(targetEntity="UserDetails\Entity\UserContacts", inversedBy="phoneNumbers")
     */
    private $userContacts;

    /**
     * @var string
     * @ORM\Column(type="string", length=256, name="phone_number")
     */
    private $phoneNumber;


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
     * @return UserContacts
     */
    public function getUserContacts(): UserContacts
    {
        return $this->userContacts;
    }

    /**
     * @param UserContacts $userContacts
     */
    public function setUserContacts(UserContacts $userContacts): void
    {
        $this->userContacts = $userContacts;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

}