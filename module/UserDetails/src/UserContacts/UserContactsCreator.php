<?php

namespace UserDetails\Creator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use User\Service\UserService;
use UserDetails\Entity\UserContacts;

class UserContactsCreator
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserContactsCreator constructor.
     *
     * @param EntityManager $entityManager
     * @param UserService   $userService
     */
    public function __construct(EntityManager $entityManager,UserService $userService)
    {
        $this->entityManager = $entityManager;
        $this->userService = $userService;
    }

    /**
     * @param array $contactParameters
     *
     * @return UserContacts
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws \Exception
     */
    public function insertUserContacts(array $contactParameters): UserContacts
    {
        $newUserContacts = $this->createUserContactsEntity($contactParameters);
        $this->entityManager->persist($newUserContacts);
        $this->entityManager->flush();

        return $newUserContacts;
    }

    /**
     * @param array $contactParameters
     *
     * @return UserContacts
     * @throws \Exception
     */
    private function createUserContactsEntity(array $contactParameters): UserContacts
    {
        $userContacts = new UserContacts();
        $userContacts->setAddress($contactParameters['address']);
        $userContacts->setPhoneNumber($contactParameters['phoneNumber']);
        $userContacts->setUser($this->userService->getById($contactParameters['id']));

        return $userContacts;
    }
}