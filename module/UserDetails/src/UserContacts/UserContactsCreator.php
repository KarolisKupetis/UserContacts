<?php

namespace UserDetails\Creator;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use User\Service\UserService;
use UserDetails\Entity\UserContacts;
use UserDetails\Service\UserPhoneNumberService;

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
     * @var UserPhoneNumberService
     */
    private $phoneNumberService;

    /**
     * UserContactsCreator constructor.
     *
     * @param EntityManager          $entityManager
     * @param UserService            $userService
     * @param UserPhoneNumberService $phoneNumberService
     */
    public function __construct(
        EntityManager $entityManager,
        UserService $userService,
        UserPhoneNumberService $phoneNumberService
    ) {
        $this->entityManager = $entityManager;
        $this->userService = $userService;
        $this->phoneNumberService = $phoneNumberService;
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
        $userContacts->setUser($this->userService->getById($contactParameters['id']));

        return $userContacts;
    }

    /**
     * @param array        $phoneNumbers
     * @param UserContacts $userContacts
     *
     * @return UserContacts
     * @throws ORMException
     */
    public function addPhoneNumbersToUserContacts(array $phoneNumbers, UserContacts $userContacts):UserContacts
    {
        foreach ($phoneNumbers as $number) {
            $userPhoneNumber = $this->phoneNumberService->createUserPhoneNumberEntity($number);

            if ($userPhoneNumber) {
                $userPhoneNumber->setUserContacts($userContacts);
                $userContacts->addPhoneNumber($userPhoneNumber);
            }
        }

        $this->entityManager->persist($userContacts);
        $this->entityManager->flush();

        return $userContacts;
    }
}