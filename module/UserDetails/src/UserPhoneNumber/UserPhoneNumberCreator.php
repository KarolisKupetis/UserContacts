<?php


namespace UserDetails\UserPhoneNumber;


use Doctrine\ORM\EntityManager;
use UserDetails\Entity\UserPhoneNumber;

class UserPhoneNumberCreator
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $phoneNumber
     *
     * @return UserPhoneNumber
     * @throws \Doctrine\ORM\ORMException
     */
    public function createPhoneNumber(string $phoneNumber): UserPhoneNumber
    {

        $phoneNumberEntity = $this->createUserPhoneNumberEntity($phoneNumber);
        $this->entityManager->persist($phoneNumberEntity);

        return $phoneNumberEntity;
    }

    /**
     * @param string $phoneNumber
     *
     * @return UserPhoneNumber
     */
    private function createUserPhoneNumberEntity(string $phoneNumber): UserPhoneNumber
    {
        $newPhoneNumberEntity = new UserPhoneNumber();
        $newPhoneNumberEntity->setPhoneNumber($phoneNumber);

        return $newPhoneNumberEntity;
    }
}