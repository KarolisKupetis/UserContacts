<?php

namespace UserContacts\Creator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use UserContacts\Entity\UserContacts;
use User\Entity\User;

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
     * @param User  $user
     * @param array $contactParameters
     *
     * @return UserContacts
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function insertUserContacts(User $user, array $contactParameters): UserContacts
    {
        $newUserContacts = $this->createUserContactsEntity($user, $contactParameters);

        $this->entityManager->persist($newUserContacts);
        $this->entityManager->flush();

        return $newUserContacts;
    }

    /**
     * @param User  $user
     * @param array $contactParameters
     *
     * @return UserContacts
     */
    private function createUserContactsEntity(User $user, array $contactParameters): UserContacts
    {
        $userContacts = new UserContacts();
        $userContacts->setAddress($contactParameters['address']);
        $userContacts->setPhoneNumber($contactParameters['phoneNumber']);
        $userContacts->setUser($user);

        return $userContacts;
    }
}