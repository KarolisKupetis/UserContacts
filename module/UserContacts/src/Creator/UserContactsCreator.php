<?php

namespace UserContacts\Creator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use UserContacts\Entity\UserContacts;
use Users\Entity\Users;

class UserContactsCreator
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Users $user
     * @param array $contactParameters
     *
     * @return int
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function insertUserContacts(Users $user, array $contactParameters): int
    {
        $newUserContacts = $this->createUserContactsEntity($user, $contactParameters);

        $this->entityManager->persist($newUserContacts);
        $this->entityManager->flush();

        return $newUserContacts->getId();
    }

    /**
     * @param Users $user
     * @param array $contactParameters
     *
     * @return UserContacts
     */
    private function createUserContactsEntity(Users $user, array $contactParameters): UserContacts
    {

        $userContacts = new UserContacts();
        $userContacts->setAddress($contactParameters['address']);
        $userContacts->setPhoneNumber($contactParameters['phoneNumber']);
        $userContacts->setUser($user);

        return $userContacts;
    }
}