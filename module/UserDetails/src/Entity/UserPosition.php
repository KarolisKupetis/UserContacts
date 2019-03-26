<?php

namespace UserDetails\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use User\Entity\User;

/**
 * @ORM\Entity(repositoryClass="UserDetails\Repository\UserPositionRepository")
 * @ORM\Table(name="positions")
 */
class UserPosition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id")
     * @var int
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=256, name = "position")
     */
    private $position;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="User\Entity\User")
     * @ORM\JoinTable(name="users_position",
     *     joinColumns={@ORM\JoinColumn(name="position_id",referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *     )
     */
    private $users;

    /**
     * UserPosition constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @param User $user
     */
    public function addUser(User $user): void
    {
        $this->users[] = $user;
    }

    /**
     * @param ArrayCollection $users
     */
    public function setUsers(ArrayCollection $users): void
    {
        $this->users = $users;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers():object
    {
        return $this->users;
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
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

}