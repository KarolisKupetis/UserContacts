<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="User\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @var int
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=256, name="name")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=256, name="email")
     */
    private $email;

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
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}